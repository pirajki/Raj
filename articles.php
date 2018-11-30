<?php
defined('IS_ADMIN') or die('Do not try to hack !');
// Article -> GoBack
if (isset($_POST['go_back'])) {    
    header("Location: " . absolute_path("index.php?edit_article"));
    exit();
}

// TODO: CSS3 tabs (no bootstrap, no JS)
// http://blogs.sitepointstatic.com/examples/tech/css3-target/tabs.html#tab1
// the only JS is ckeditor

// Delete article from database
if (isset($_POST['article_delete']) && isset($_GET['edit_article']) && csrfProtection::verifyToken()) {
    $Db->beginTransaction();    
    $Db->execute('DELETE FROM articles WHERE id=%u', $_GET['edit_article']);
    $Db->execute('DELETE FROM comments WHERE article_id=%u', $_GET['edit_article']);
    $Db->commit();
    header("Location: " . absolute_path("index.php?edit_article"));
    exit();
}

// Save the article to database
if (isset($_POST['article_save']) && csrfProtection::verifyToken()) {
    if (empty($_POST['article_title'])) {
        $errors[] = _("Title cannot be empty");
    } elseif (80 < strlen($_POST['article_title']) || 3 > strlen($_POST['article_title'])) {
        $errors[] = _("Article title must be between 3 and 80 characters.");
    }
    
    if (array_key_exists("image", $_FILES) && !empty($_FILES['image']['name'])) {
        $code = $_FILES['image']['error'];
        if ($code != UPLOAD_ERR_OK) {
            $errors[] = sprintf(_("An error has occurred during image upload: %s"), fileUploadCodeToMessage($code));
        }
        
        if (empty($errors)) {
            // if tmp_name is spoofed it can point to /etc/passwd, for example
            $size = getimagesize($_FILES['image']['tmp_name']);
            if ($size[0] > 6000 || $size[1] > 6000) {
                $errors[] = sprintf(_("Image resolution is higher than 6000x6000px. Please upload a smaller image. Resolution is %s x %s pixels", $size[0], $size[1]));
            } else if ($size === FALSE || $size[0] < 10 || $size[1] < 10) {
                $errors[] = sprintf(_("Uploaded file is not an image!"));
            }
        }
        
        // More extensive file type check (unsupported by JVM hosting)
        /*
        if (empty($errors)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $info = finfo_file($finfo, $_FILES['image']['tmp_name']);
            finfo_close($finfo);
            
            $allowedImages = array("jpg", "jpeg", "png", "gif", "bmp");
            $filterPassed = FALSE;
            foreach ($allowedImages as $allowedImage) {
                if (strpos($info, $allowedImage) !== FALSE) {
                    $filterPassed = TRUE;
                    break;
                }
            }
            
            if (!$filterPassed) {
                $errors[] = sprintf(_("Invalid file type. File is not a recognized image: '%s'", $info));
            }
        }*/
        
        $extension = NULL;        
        if (empty($errors)) {
            $imageType = getimagesize($_FILES['image']['tmp_name']);
            $imageType = $imageType['mime'];
            if (FALSE !== strpos($imageType, "gif"))
                $extension = "gif";

            if (FALSE !== strpos($imageType, "jpeg"))
                $extension = "jpeg";
                
            if (FALSE !== strpos($imageType, "png"))
                $extension = "png";                    
            
            if ($extension == NULL) {
                $errors[] = _("Uploaded file is not an image or its format is unsupported.");
            }
        }
        
        if (empty($errors) && !is_uploaded_file($_FILES['image']['tmp_name'])) {
            $errors[] = sprintf(_("File is not an uploaded file!"));
        }
    }
    
    if (empty($_POST['article'])) {
        $errors[] = _("Article cannot be empty.");
    } elseif (100 > strlen($_POST['article'])) {
        $errors[] = _("The article is too short. It should have at least 100 characters.");
    } elseif (FALSE === strpos($_POST['article'], "<p>") || FALSE === strpos($_POST['article'], "</p>")) {
        //$errors[] = _("The article must contain at least one paragraph delimited by tags <p> and </p>.");
    }
    
    try {
        $parser->parse($_POST['article']);
    } catch (Exception $e) {
        $errors[] = _("Your (X)HTML code is invalid, therefore it cannot be processed by the parser.");
    }
    
    if (0 == sizeof($errors) && !isset($_GET['edit_article'])) {
        $results = $Db->execute("SELECT COUNT(*) AS articleExists FROM articles WHERE title=%s", $_POST['article_title']);
        if (0 != $results[0]["articleExists"]) {
            $errors[] = _("An article with the same title already exists.");
        }
        
        $results = $Db->execute("SELECT COUNT(*) AS articleExists FROM articles WHERE article=%s", $_POST['article']);
        if (0 != $results[0]["articleExists"]) {
            $errors[] = _("An article with the exact same content already exists.");
        }        
    }
    
    if (0 != sizeof($errors)) {
        $articleError = 1;
    } else {
        if ((isset($_GET['edit_article']) && is_numeric($_GET['edit_article'])) || (isset($_GET['article_history']) && is_numeric($_GET['article_history']))) {
            //////////////// ************   Raj    *******/////////////////
      //     $results = $Db->execute("INSERT INTO article_history (article_id, category, title, article, timestamp_old, status, author, coolUrl, language, pageTitle, pageKeywords, pageDescription, cs_version, en_version) SELECT id, category, title, article, timestamp, status, author, coolUrl, language, pageTitle, pageKeywords, pageDescription, cs_version, en_version FROM articles WHERE  id=%u", $_GET['edit_article']);
            $results = $Db->execute("SELECT * FROM articles WHERE id=%u", $_GET['edit_article']);
            if (0 != sizeof($results)) {
                $results         = $results[0];
                $idValue         = $results['id'];
                $categoryValue   = $results['category'];
                $titleValue      = $results['title'];
                $articleValue    = $results['article'];
                $timestampValue  = $results['timestamp'];
                $statusValue     = $results['status'];
                $authorValue     = $results['author'];
                $coolUrlValue     = $results['coolUrl'];
                $language       =   $results['language'];
                $pageTitle       = $results['pageTitle'];
                $pageKeywords    = $results['pageKeywords'];
                $pageDescription = $results['pageDescription'];
                $cs_version     = $results['cs_version'];
                $en_version     = $results['en_version'];
                $Db->execute("INSERT INTO article_history (article_id, category, title, article, timestamp_old, timestamp, status, author, coolUrl, language, pageTitle, pageKeywords, pageDescription, cs_version, en_version) VALUES (%u, %u, %s, %s, %s, NOW(), %u, %s, %s, %s, %s, %s, %s, %u, %u)",
                    $idValue,
                    $categoryValue,
                    $titleValue,
                    $articleValue,
                    $timestampValue,
                    $statusValue ,
                    $authorValue,
                    $coolUrlValue,
                    $language,
                    $pageTitle,
                    $pageKeywords,
                    $pageDescription,
                    $cs_version,
                    $en_version
                );
           } elseif (0 == sizeof($results)) {
                // bad edit_article history value
                $errors[] = _("The specified article cannot be found.");
            }
///////////////////////// *********   /Raj   ****//////////////////////
            $Db->execute("UPDATE articles SET title=%s, category=%u, article=%s, status=%u, coolUrl=%s, language=%s, pageTitle=%s, pageKeywords=%s, pageDescription=%s, cs_version=%u, en_version=%u WHERE id=%u LIMIT 1",
                $_POST['article_title'],
                $_POST['article_category'],
                $_POST['article'],
                $_POST['article_status'],
                slugify($_POST['article_title']),
                $_lng,
                $_POST['page_title'],
                $_POST['page_keywords'],
                $_POST['page_description'],
                isset($_POST['cs_version']) ? $_POST['cs_version'] : NULL,
                isset($_POST['en_version']) ? $_POST['en_version'] : NULL,
                $_GET['edit_article']                
            );
            if (array_key_exists("image", $_FILES) && !empty($_FILES['image']['tmp_name'])) {
                $destination = IMG_UPLOAD_DIR . sprintf("image_%u.%s", $_GET['edit_article'], $extension);
                if (FALSE === move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $errors[] = _("Unable to upload the image!");
                } else {
                    if ($extension != "jpg") {
                        $resize = new Resize($destination);
                        $resize->flushAllCache();
                        $resize->saveImage($destination, "jpg");
                        unlink($destination);
                    }
                }
            }
            
            if (empty($errors)) {
                //header("Location: " . absolute_path("index.php?edit_article"));
                header("Location: " . absolute_path("index.php?edit_article=" . (int)$_GET['edit_article'] . "&token=" . csrfProtection::getToken()));
                exit();
            }
        } else {
            $Db->execute("INSERT INTO articles (title, category, article, timestamp, status, author, coolUrl, language, pageTitle, pageKeywords, pageDescription, cs_version, en_version) VALUES (%s, %u, %s, NOW(), %u, %u, %s, %s, %s, %s, %s, %u, %u)",
                $_POST['article_title'],
                $_POST['article_category'],
                $_POST['article'],
                $_POST['article_status'],
                $_SESSION['admin_logged'],
                slugify($_POST['article_title']),
                $_lng,
                $_POST['page_title'],
                $_POST['page_keywords'],
                $_POST['page_description'],
                isset($_POST['cs_version']) ? $_POST['cs_version'] : NULL,
                isset($_POST['en_version']) ? $_POST['en_version'] : NULL
            );
            if (array_key_exists("image", $_FILES) && !empty($_FILES['image']['tmp_name'])) {
                $result = $Db->execute("SELECT id FROM articles WHERE title=%s", $_POST['article_title']);
                $id = $result[0]['id'];

                $destination = IMG_UPLOAD_DIR . sprintf("image_%s.%s", $id, $extension);
                if (FALSE === move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $errors[] = _("Unable to upload the image!");
                } else {
                    if ($extension != "jpg") {
                        $resize = new Resize($destination);
                        $resize->flushAllCache();
                        $resize->saveImage($destination, "jpg");
                        unlink($destination);
                    }
                }
            }
            
            if (empty($errors)) {
                header("Location: " . absolute_path("index.php?edit_article"));
                exit();
            }            
        }
    }    
}

// Preview for the article
if (isset($_POST['article_preview'])) {    
    $preview = $tpl->createBlock("article_preview", $right);
    try {
        //$parser->parse($_POST['article']);
    } catch (Exception $e) {
        $infoBox = $tpl->createBlock('info_box', $preview);
        $tpl->assignVar('message', _("An error has occurred while parsing the article."), $infoBox);
        if (IS_DEBUG) {
            $backtrace = '<br /><br /><strong>Backtrace</strong><br />' . $e->getTraceAsString();
        } else {
            $backtrace = '';
        }
        
        $tpl->assignVar('details', $e->getMessage() . $backtrace, $infoBox, FALSE);
    }

    if (isset($_GET['edit_article'])) {
        $action = absolute_path("index.php?edit_article={$_GET['edit_article']}");
    } else {
        $action = absolute_path("index.php?new_article=");
    }
        
    $tpl->assignVars(
        array(
            "articletext" => $_POST['article'],
            "action" => $action,
            "articletitle" => $_POST['article_title'],
            "category" => $_POST['article_category'],
            "articlestatus" => $_POST['article_status'],
            'page_title' => $_POST['page_title'],
            'page_keywords' => $_POST['page_keywords'],
            'page_description' => $_POST['page_description'],
            "back" => _("Back"),
            "token" => csrfProtection::getToken()
        ), $preview
    );
    $tpl->assignVar("parsedarticle", str_replace("]", ">", str_replace("[", "<", $_POST['article'])), $preview, FALSE);
}

// New article and Edit article
if ((isset($_GET['new_article']) && '' == $_GET['new_article']) ||(isset($_GET['article_history']) && isset($_GET['edit_article']) && ''== $_GET['article_history']) || isset($articleError) || (isset($_GET['edit_article'])) && is_numeric($_GET['edit_article']) && !isset($_POST['article_preview'])) {
    $results = $Db->execute("SELECT id, name FROM categories ORDER BY id");    
    for ($i = 0; $i < sizeof($results); $i++) {
        $categories[$results[$i]['id']] =& $results[$i]['name'];
    }
    
    $articleValue = isset($_POST['article']) ? htmlspecialchars($_POST['article'], ENT_QUOTES) : $articleValue = '';
    $titleValue =  isset($_POST['article_title']) ? $_POST['article_title'] : $titleValue = '';
    $categoryValue = isset($_POST['article_category']) ? $_POST['article_category'] : $categoryValue = '';
    $statusValue =  isset($_POST['article_status']) ? $_POST['article_status'] : $statusValue = '';
    $pageTitle = isset($_POST['page_title']) ? $_POST['page_title'] : "";
    $pageKeywords = isset($_POST['page_keywords']) ? $_POST['page_keywords'] : "";
    $pageDescription = isset($_POST['page_description']) ? $_POST['page_description'] : "";
    
    $article = $tpl->createBlock("article", $right);
    
    if (isset($_GET['edit_article'])|| isset($_GET['article_history'])) {
        // edit article
        if(isset($_GET['edit_article']) && isset($_GET['article_history']) !='y') {
            $results = $Db->execute("SELECT article, title, category, status, pageTitle, pageKeywords, pageDescription FROM articles WHERE id=%u", $_GET['edit_article']);
        }elseif(isset($_GET['edit_article']) && isset($_GET['article_history']) =='y'){
            $results = $Db->execute("SELECT article, title, category, status, pageTitle, pageKeywords, pageDescription FROM article_history WHERE id=%u", $_GET['article_history']);
        }

        if (0 != sizeof($results) && !isset($_POST['article'])) {
            $results         = $results[0];
            $articleValue    = htmlspecialchars($results['article'], ENT_QUOTES);
            $titleValue      = $results['title'];
            $categoryValue   = $results['category'];
            $statusValue     = $results['status'];
            $pageTitle       = $results['pageTitle'];
            $pageKeywords    = $results['pageKeywords'];
            $pageDescription = $results['pageDescription'];
        } elseif (0 == sizeof($results)) {
            // bad edit_article value
            $errors[] = _("The specified article cannot be found.");
        }
        
        $tpl->assignVar("title", _("Edit article"), $article);
        $versions = $tpl->createBlock("versions", $article);
        $articleVersions = $Db->execute("SELECT id, title FROM articles WHERE language!=%s", $_lng);
        $items = array();
        foreach ($articleVersions as $version) {
            $items[$version['id']] = $version['id'] . ' => ' . $version['title'];
        }
        
        if ($_lng == "en")
            createSelect($tpl, $versions, _("Czech version"), "cs_version", $items);
        else 
            createSelect($tpl, $versions, _("English version"), "en_version", $items);
        
        $tpl->assignVar("action", absolute_path('{.current_url}'));
        $editArticle = $tpl->createBlock("edit_article", $article, $right);
        $tpl->assignVars(array(
            "delete" => _("Delete"),
            "go_back" => _("Back")
            ), $editArticle
        );
        ///////////////////////       Raj        /////////////////////////////
            $order_history       = "";
            static $allowed_history    = array("title", "category", "author", "timestamp", "viewed");
            $translations_history = array(
                'title' => _("Title"),
                'category' => _("Category"),
                'author' => _("Author"),
                'timestamp' => _("Timestamp"),
                'viewed' => _("Viewed")
            );
            static $directions_history = array("ASC", "DESC");
            $sortCorrect_history = FALSE;
            if (isset($_GET['sort'])) {
                $sort_history  = explode("*", $_GET['sort_history']);
                $order_history = $sort_history[0];
                $direction_history = strtoupper($sort_history[1]);
                if (in_array($order_history, $allowed_history) && in_array($direction_history, $directions_history)) {
                    $sortCorrect_history = TRUE;
                }
            }
            if (FALSE === $sortCorrect_history) {
                $order_history     = 'status DESC, id';
                $direction_history = 'DESC';
            }
            $edit_history = $tpl->createBlock("edit_article_menu", $article, $right);
            $tpl->assignVar("newArticleHistory", _("New Article History"), $edit_history);
            $tpl->assignVar("newArticleLinkHistory", absolute_path('index.php') . '?new_article', $edit_history);
            $tpl->assignVar("borders", " class='borders'", $edit_history, FALSE);
            $tpl->assignVar("title", _("Article History"), $edit_history);
            // Draw table header
            foreach ($allowed_history as $value) {
                if ($order_history == $value && $direction_history == "ASC") {
                    $ascOrDesc_history = "desc";
                } else {
                    $ascOrDesc_history = "asc";
                }
                $tpl->assignVar("header_$value", $translations_history[$value], $edit_history);
                $tpl->assignVar("header_image", _("Image"), $edit_history);
                $tpl->assignVar($value . "_link", absolute_path("index.php?edit_article&sort_history={$value}*{$ascOrDesc_history}"), $edit_history);
            }
            $results_history = $Db->execute(
                "SELECT a.*, c.name FROM article_history a, articles b, categories c WHERE a.article_id=b.id AND a.category=c.id AND a.article_id=%u",$_GET['edit_article']);
            // Draw items
            for ($i = 0; $i < sizeof($results_history); $i++) {
                $item_history = $tpl->createBlock("item_history", $edit_history);
                $tpl->assignVars(array(
                    "number" => ($i & 1) + 1,
                    "article_id" => $results_history[$i]['article_id'],
                    "id" => $results_history[$i]['article_id'],
                    "image" => str_replace("admin/img", "img", $tpl->resize(absolute_path("../img/image_" . $results_history[$i]['id'] . ".jpg"), 32, 32)),
                    "title" => $results_history[$i]['title'],
                    "category" => $results_history[$i]['name'],
                  //  "status" => 0 == $results_history[$i]['status'] ? ucfirst(_("finished")) : ucfirst(_("draft")),
                    "author" => $results_history[$i]['author'],
                    "timestamp" => $results_history[$i]['timestamp'],
                    "viewed" => $results_history[$i]['viewed'],
                    "href" => absolute_path("index.php?edit_article={$results_history[$i]['article_id']}&article_history={$results_history[$i]['id']}&token=" . csrfProtection::getToken())
                ), $item_history);
            }
/// //////////////////////////////    /raj     /////////////////
    } else {
		// XXX store the article draft in $_SESSION when the user clicks Preview. 
		// That way if the user is redirected outside the CMS and loses the draft, 
		// the CMS will again autofill the lost article draft in the textarea from $_SESSION. 
		
        // new article
        $tpl->assignVars(
            array(
                "title"  => _("New article"),
                "action" => absolute_path("index.php?new_article=2")
            ), $article
        );
    }
    $tpl->assignVars(array(
            "save" => _("Save"),
            "key" => strtolower(_("Article")[0]),
            "first" => _("Article")[0],
            "last" => substr(_("Article"), 1),
            "reupload_image" => _("(Re)upload article image"),
            "preview" => _("Preview"),
            'page_title' => $pageTitle,
            'page_keywords' => $pageKeywords,
            'page_description' => $pageDescription
        ), $article
    );
    
    if (isset($errors) && 0 != sizeof($errors)) {
        // draw the errors
        $errorList = $tpl->createBlock("error_list", $article);
        foreach ($errors as $text) {
            $item = $tpl->createBlock("item", $errorList);
            $tpl->assignVar("text", $text, $item);
        }        
    }
    
    createField($tpl, $article, _("Title"), "article_title", $titleValue);
    createField($tpl, $article, "", "token", csrfProtection::getToken(), "hidden");
    createSelect($tpl, $article, _("Category"), "article_category", $categories, $categoryValue);
    $tpl->assignVar("article_value", $articleValue, $article, FALSE);
    $tpl->assignVars(
        array(
            "article_status" => _("Article status"),
            "finished" => _("finished"),
            "draft" => _("draft")
        ), $article
    );
    switch ($statusValue) {
        case ARTICLE_STATUS_FINISHED :
            $tpl->assignVar('is_finished', " checked='checked'", $article, FALSE);
            break;
            
        case ARTICLE_STATUS_DRAFT :
            $tpl->assignVar('is_draft', " checked='checked'", $article, FALSE);
            break;
            
        default :
            throw new Exception('Unknown status of article');
    }
}

// The menu with all articles
if (isset($_GET['edit_article']) && '' == $_GET['edit_article']) {
    $order       = "";
    static $allowed    = array("id", "title", "category", "status", "author", "timestamp", "viewed");
    $translations = array(
        'id' => _("ID"),
        'title' => _("Title"),
        'category' => _("Category"),
        'status' => _("Status"),
        'author' => _("Author"),
        'timestamp' => _("Timestamp"),
        'viewed' => _("Viewed")
    );
    static $directions = array("ASC", "DESC");
    $sortCorrect = FALSE;
    if (isset($_GET['sort'])) {
        $sort  = explode("*", $_GET['sort']);
        $order = $sort[0];
        $direction = strtoupper($sort[1]);
        if (in_array($order, $allowed) && in_array($direction, $directions)) {
            $sortCorrect = TRUE;
        }
    }
    
    if (FALSE === $sortCorrect) {
        $order     = 'status DESC, id';
        $direction = 'DESC';
    }
    
    $edit = $tpl->createBlock("edit_article_menu", $right);
    $tpl->assignVar("newArticle", _("New Article"), $edit);
    $tpl->assignVar("newArticleLink", absolute_path('index.php') . '?new_article', $edit);
    $tpl->assignVar("borders", " class='borders'", $edit, FALSE);
    $tpl->assignVar("title", _("Edit article"), $edit);
    // Draw table header
    foreach ($allowed as $value) {            
        if ($order == $value && $direction == "ASC") {                
            $ascOrDesc = "desc";
        } else {
            $ascOrDesc = "asc";
        }

        $tpl->assignVar("header_$value", $translations[$value], $edit);
        $tpl->assignVar("header_image", _("Image"), $edit);
        $tpl->assignVar($value . "_link", absolute_path("index.php?edit_article&sort={$value}*{$ascOrDesc}"), $edit);
    }
        
    $results = $Db->execute(
        "SELECT DISTINCT a.id, a.title, a.status, a.timestamp, a.viewed, c.name, u.name AS authorsName " . 
        "FROM articles a, categories c, users u " .
        "WHERE a.category=c.id AND a.author=u.id AND a.language=%s" .
        "ORDER BY $order $direction", $_lng
    );

    // Draw items
    for ($i = 0; $i < sizeof($results); $i++) {
        $item = $tpl->createBlock("item", $edit);        
        $tpl->assignVars(array(
            "number" => ($i & 1) + 1,
            "id" => $results[$i]['id'],
            "image" => str_replace("admin/img", "img", $tpl->resize(absolute_path("../img/image_" . $results[$i]['id'] . ".jpg"), 32, 32)),
            "title" => $results[$i]['title'],
            "category" => $results[$i]['name'],
            "status" => 0 == $results[$i]['status'] ? ucfirst(_("finished")) : ucfirst(_("draft")),
            "author" => $results[$i]['authorsName'],
            "timestamp" => $results[$i]['timestamp'],
            "viewed" => $results[$i]['viewed'],            
            "href" => absolute_path("index.php?edit_article={$results[$i]['id']}&token=" . csrfProtection::getToken())
        ), $item);
    }    
}
?>
