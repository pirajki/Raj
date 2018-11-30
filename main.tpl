<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='cs'>
<head>
  <meta http-equiv='content-type' content='{content_type};charset=utf-8' />
  <meta name='robots' content='noindex,follow' />
  <meta name='revisit-after' content='1 days' />
  <meta name='content-language' content='cs' />
  <meta http-equiv='cache-control' content='no-cache' />
  <meta http-equiv='imagetoolbar' content='no' />
  <meta name='mssmarttagspreventparsing' content='true' />
  <title>{title}</title>
  <link type='text/css' href='{.template_path}css/style.css' rel="stylesheet" />
  <link type='text/css' href='{.template_path}css/jquery-ui.css' rel="stylesheet" />
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
  <script type="text/javascript" src="{.template_path}ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="{.template_path}js/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="{.template_path}js/jquery-ui.min.js"></script>
  </head>
<body>
  <div><a href='{.server}' id='header'>{title}</a></div>
  <!-- begin admin_login -->
  <div id='admin_login'>
    <h1>{title}</h1>
    <!-- begin error_box -->
    <div id='error_box'>
      {message}
    </div>
    <br />
    <!-- end error_box -->
    <form action='{action}' method='post'>
      <fieldset>
      	<i class="fa fa-lock" style="font-size:80px;position:relative; top:100px; left:20px"></i>
        <table>
          <!-- begin field -->
          <tr style="position:relative;left:80px;">
            <!-- begin label -->
            <td>
              <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label><br />
            </td>
            <!-- end label -->
            <td style="position:relative;left:-80px">
              <input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} />
            </td>
          </tr>
          <!-- end field -->
        </table>         
      </fieldset>
    </form>
  </div>
  <!-- end admin_login -->
  <!-- begin right_column -->  
  <div id='right'>
    <!-- begin article_preview -->
    <div class='article_preview'>
      <!-- begin info_box -->
      <div id='info_box'>
        {message}
        <div id='details'>
          {details}
        </div>
      </div>
      <!-- end info_box -->
      <h1>{articletitle}</h1>
      {parsedarticle}
      <form action='{action}' method='post'>
        <fieldset>
          <input type='hidden' name='article_title' value='{articletitle}' />
          <input type='hidden' name='article_category' value='{category}' />
          <input type='hidden' name='article_status' value='{articlestatus}' />
          <textarea name='article' style='display:none'>{articletext}</textarea>
          <input type='hidden' name='page_keywords' value='{page_keywords}' />
          <input type='hidden' name='page_title' value='{page_title}' />
          <input type='hidden' name='page_description' value='{page_description}' />
          <input type='hidden' name='token' value='{token}' />
          <input type='submit' name='article_back' value='{back}' />
        </fieldset>
      </form>	  
    </div>
    <!-- end article_preview -->
    <!-- begin edit_article_menu -->
    <h1>{title}</h1>        
    <div id='configuration'>
    
            <div style="float:right;font-size: 10px;margin-right:10px">
                                                <a id="navEng" href="{.current_url}&amp;language=en" class="language">
                                                    <img id="imgNavEng" src="{.absolute_path}../{.template_path}resources/img/en.png" alt="..." class="img-thumbnail icon-small">
                                                    <span id="lanNavEng">EN</span>
                                                </a>

                                                <a id="navCze" href="{.current_url}&amp;language=cs" class="language">
                                                    <img id="imgNavCze" src="{.absolute_path}../{.template_path}resources/img/cs.png" alt="..." class="img-thumbnail icon-small">
                                                    <span id="lanNavCze">CS</span>
                                                </a>
            </div>
    
    <a href="{newArticleLink}">{newArticle}</a>
    <table{borders} style='border:0'>
      <thead class='header'>
        <tr>
          <td>{header_image}</td>
          <td><a href='{id_link}'>{header_id}</a></td>
          <td><a href='{title_link}'>{header_title}</a></td>
          <td><a href='{category_link}'>{header_category}</a></td>
          <td><a href='{status_link}'>{header_status}</a></td>
          <td><a href='{author_link}'>{header_author}</a></td>
          <td><a href='{timestamp_link}'>{header_timestamp}</a></td>
          <td><a href='{viewed_link}'>{header_viewed}</a></td>
        </tr>
      </thead>
      <tbody>
        <!-- begin item -->
        <tr class='record{number}' onclick='javascript:window.location.href = "{href}"'>
          <td>
          	<img src="{image}" alt="">
          </td> 
          <td>{id}</td>
          <td><a href='{href}'>{title}</a></td>
          <td>{category}</td>
          <td>{status}</td>
          <td>{author}</td>
          <td>{timestamp}</td>
          <td>{viewed}</td>
        </tr>
        <!-- end item -->
      </tbody>      
    </table>
    </div>    
    <!-- end edit_article_menu -->
    <!-- begin article -->
    <h1>{title}</h1>
    <!-- begin error_list -->
    <div class='error'>
      <!-- begin item -->
      {text}<br />
      <!-- end item -->
    </div>
    <!-- end error_list -->
	<script type="text/javascript">
		$(document).ready(function() {
			$( "#tabs" ).tabs();
		});			
	</script>
    
    <form action='{action}' method='post' enctype='multipart/form-data'>
      <fieldset>        		
        <div id="tabs">
        	<ul class="nav nav-tabs">
        		<li><a href="#tabs-1">Article</a></li>
        		<li><a href="#tabs-2">SEO</a></li>        		
        		<li><a href="#tabs-3">Versions</a></li>
                <li><a href="#tabs-4">History</a></li>
        	</ul>
        	<div id="tabs-1">
		        <!-- begin field -->
		        <!-- begin label -->
		        <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label>
		        <!-- end label -->
		        <input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} /><br />
		        <!-- end field -->
		        
		        <!-- begin select -->
		        <!-- begin label -->
		        <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
		        <!-- end label -->
		        <select id='{name}' name='{name}'>
		        <!-- begin item -->
		          <option value='{value}'{selected}>{description}</option>
		        <!-- end item -->
		        </select>
		        <!-- end select -->
		        <span id='article_status'>{article_status}:</span>
		        <input type='radio' name='article_status' value='0' id='articleFinished'{is_finished} />
		        <label for='articleFinished'>{finished}</label>
		        <input type='radio' name='article_status' value='1' id='articleUnfinished'{is_draft} />
		        <label for='articleUnfinished'>{draft}</label>

				<div style="float:right">		                
			        <label for='image' id='image'>{reupload_image}:</label>
			       	<input type="file" name="image" id="image"><br />
		       	</div>
        	
		        <textarea rows='18' cols='80' id='article' class="article_preview" name='article'>{article_value}</textarea><br />
		    </div>
		    <div id="tabs-2">
		    	<label for='pageTitle'>Page Title:</label>
		    	<input type="text" id="pageTitle" name="page_title" value="{page_title}" /><br />
		    	
		    	<label for='pageTitle'>Keywords:</label>
		    	<input type="text" id="pageKeywords" name="page_keywords" value="{page_keywords}" /><br />

		    	<label for='pageTitle'>Description:</label>
		    	<input type="text" id="pageDescription" name="page_description" value="{page_description}" /><br />		    			        
		    </div>
		    <div id="tabs-3">
		    	<!-- begin versions -->
			        <!-- begin select -->
			        <!-- begin label -->
			        <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
			        <!-- end label -->
			        <select id='{name}' name='{name}'>
			        <!-- begin item -->
			          <option value='{value}'{selected}>{description}</option>
			        <!-- end item -->
			        </select>
			        <!-- end select -->
			    <!-- end versions -->
		    </div>
          <div id="tabs-4">

            <!-- begin edit_article_menu -->
            <h1>{title}</h1>
            <div id='configuration'>
              <a href="{newArticleLink}">{newArticle}</a>
              <table{borders} style='border:0'>
                <thead class='header'>
                <tr>
                  <td>{header_image}</td>
                  <td><a href='{timestamp_link}'>{header_timestamp}</a></td>
                  <td><a href='{title_link}'>{header_title}</a></td>
                  <td><a href='{category_link}'>{header_category}</a></td>

                  <td><a href='{author_link}'>{header_author}</a></td>


                </tr>
                </thead>
                <tbody>
                <!-- begin item_history -->
                <tr class='record{number}' onclick='javascript:window.location.href = "{href}"'>
                  <td>
                    <img src="{image}" alt="">
                  </td>
                  <td>{timestamp}</td>
                  <td><a href='{href}'>{title}</a></td>
                  <td>{category}</td>

                  <td>{author}</td>


                </tr>
                <!-- end item_history -->
                </tbody>
              </table>
            </div>
            <!-- end edit_article_menu -->
          </div>
        </div>
        
        <input type='submit' name='article_preview' value='{preview}' />
        <input type='submit' name='article_save' value='{save}' />
        <!-- begin edit_article -->
        <input type='submit' name='article_delete' value='{delete}' />
        <input type='submit' name='go_back' value='{go_back}' />
        <!-- end edit_article -->
      </fieldset>
    </form>
	  <script type="text/javascript">
		CKEDITOR.dtd.$removeEmpty['i'] = false;
		CKEDITOR.dtd.$removeEmpty['span'] = false;
		CKEDITOR.replace( 'article' );
	  </script>

    <!-- end article -->
    <!-- begin comments -->
    <h1>{title}</h1>
    <!-- begin comments_not_exists -->
    <p>{message}</p>
    <!-- end comments_not_exists -->
    <!-- begin comments_exists -->
    <form action='{action}' method='post'>
      <fieldset id='configuration'> 
        <table{borders} style='border:0'>
          <thead>
            <tr class='header'>
              <td></td>
              <td><a href='{id_link}'>{id}</a></td>
              <td><a href='{author_link}'>{author}</a></td>
              <td><a href='{web_link}'>{web}</a></td>
              <td><a href='{email_link}'>{email}</a></td>
              <td><a href='{ip_address_link}'>{ip_address}</a></td>
              <td><a href='{display_link}'>{accepted}</a></td>
              <td><a href='{timestamp_link}'>{timestamp}</a></td>
            </tr>
          </thead>
          <tbody>
            <!-- begin item -->
            <tr class='record{class}'>
              <td class='comment_field'>
                <input type='checkbox' name='{name}'{checked} />
              </td>
              <td>{id}</td>
              <td onclick='window.location = "{link}"'><a href='{link}' title='{full_author}'>{author}</a></td>
              <td onclick='window.location = "{link}"'><a href='{link}' title='{full_web}'>{web}</a></td>
              <td onclick='window.location = "{link}"'><a href='{link}' title='{full_email}'>{email}</a></td>
              <td onclick='window.location = "{link}"'>{ip_address}</td>
              <td onclick='window.location = "{link}"'>{display}</td>
              <td onclick='window.location = "{link}"'>{timestamp}</td>
            </tr>
            <!-- end item -->
          </tbody>
        </table>
        <!-- begin paging -->
          <div class='paging'>
          <!-- begin page_start -->
          <a href='{link}'>&#60;&#60;</a>
          <!-- end page_start -->
          <!-- begin page_start_disabled -->
          <span>&#60;&#60;</span>
          <!-- end page_start_disabled -->
          <!-- begin page_left -->
          <a href='{link}'>&#60;</a>
          <!-- end page_left -->
          <!-- begin page_left_disabled -->
            <span>&#60;</span>
          <!-- end page_left_disabled -->
            <div>({current_page}/{max_page})</div> 
          <!-- begin page_right -->
          <a href='{link}'>&#62;</a>
          <!-- end page_right -->
          <!-- begin page_right_disabled -->
            <span>&#62;</span>
          <!-- end page_right_disabled -->
          <!-- begin page_finish -->
          <a href='{link}'>&#62;&#62;</a>
          <!-- end page_finish -->
          <!-- begin page_finish_disabled -->
            <span>&#62;&#62;</span>
          <!-- end page_finish_disabled -->
        </div>
        <!-- end paging -->
        <!-- begin select -->
        <!-- begin label -->
        <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
        <!-- end label -->
        <select id='{name}' name='{name}'>
        <!-- begin item -->
        <option value='{value}'{selected}>{description}</option>
        <!-- end item -->
        </select>
        <!-- end select -->
        
        <!-- begin field -->
        <!-- begin label -->
        <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label>
        <!-- end label -->
        <input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} />
        <!-- end field -->        
      </fieldset>
    </form>    
    <!-- end comments_exists -->
    <!-- end comments -->
    <!-- begin comment -->
    <h1>{title}</h1>
    <!-- begin error -->
    <p>{message}</p>
    <!-- end error -->
    <!-- begin success -->
    <form action='{action}' method='post'>
      <fieldset class='comment'>
        {id}: {id_value}<br />
        {parent_id}: {parent_id_value}<br />
        {timestamp}: {timestamp_value}<br />
        {subject}: {subject_value}<br />
        {author}: {author_value}<br />
        {email}: {email_value}<br />
        {web}: {web_value}<br />
        {ip_address}: {ip_address_value}<br /><br />
        <textarea name='comment' cols='80' rows='14'>{comment_value}</textarea><br />
        <input type='submit' name='comment_accept' value='{continue}' />
        <input type='submit' name='comment_reject' value='{delete}' />
        <input type='submit' name='comment_goback' value='{go_back}' />
        <!-- begin field -->
        <!-- begin label -->
        <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label>
        <!-- end label -->
        <input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} />
        <!-- end field -->        
      </fieldset>
    </form>
    <!-- end success -->
    <!-- end comment -->
    <!-- begin plugins -->
    <h1>{title}</h1>
    <div id='configuration'>
      <!-- begin info_box -->
        <div id='info_box'>
          {error_message}
          <div id='details'>
            {details}
          </div>
        </div>
      <!-- end info_box -->
      <form action='{action}' method='post'>
        <table{borders} style='border:0'>
          <thead class='header'>
          <tr>
            <td colspan='2'><a href='#'>{header_action}</a></td>
            <td><a href='{name_link}'>{header_name}</a></td>
            <td><a href='{description_link}'>{header_description}</a></td>
            <td><a href='{installed_link}'>{header_installed}</a></td>
          </tr>
        </thead>
        <tbody>
          <!-- begin item -->
          <tr class='record{number}' onclick='javascript:window.location.href = "{href}"'>
            <td class='checkbox'><input type='checkbox' /></td>
            <!-- begin install -->
            <td class='checkbox'><a href='{link_install}'>
              <img src='{.template_path}img/edit.png' alt='edit' /></a>
            </td>
            <!-- end install -->
            <!-- begin delete -->
            <td class='checkbox'><a href='{link_delete}'>
              <img src='{.template_path}img/delete.png' alt='delete' /></a>
            </td>
            <!-- end delete -->
            <td>{name}</td>
            <td>{description}</td>
            <td>{installed}</td>
          </tr>
          <!-- end item -->
        </tbody>
      </table>
    
      <div>
        <!-- begin select -->
        <!-- begin label -->
        <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
        <!-- end label -->    
        <select id='{name}' name='{name}'>
        <!-- begin item -->
          <option value='{value}'{selected}>{description}</option>
        <!-- end item -->
        </select>
        <!-- end select -->
        <!-- begin field -->
        <input type='{type}' name='{name}' value='{value}' {checked}{readonly} />
        <!-- end field -->
      </div>
    </form>
    </div>
    <!-- end plugins -->    
    <!-- begin configuration -->
    <h1>{title}</h1>
    <!-- begin error_list -->
    <div id='error_box'>
      <!-- begin item -->
      {text}<br />
      <!-- end item -->
    </div>
    <br />
    <!-- end error_list -->
            <div style="float:right;font-size: 10px;margin-right:10px">
                                                <a id="navEng" href="{.current_url}&amp;language=en" class="language">
                                                    <img id="imgNavEng" src="{.absolute_path}../{.template_path}resources/img/en.png" alt="..." class="img-thumbnail icon-small">
                                                    <span id="lanNavEng">EN</span>
                                                </a>

                                                <a id="navCze" href="{.current_url}&amp;language=cs" class="language">
                                                    <img id="imgNavCze" src="{.absolute_path}../{.template_path}resources/img/cs.png" alt="..." class="img-thumbnail icon-small">
                                                    <span id="lanNavCze">CS</span>
                                                </a>
            </div>
            <div style="clear:both">
            </div>
    
    <!-- begin create_backup -->
    	<a href='{createBackupLink}'>{createBackup}</a>
    <!-- end create_backup -->
    
    <form action='{action}' method='post'{special_form_attributes}>
      <fieldset id='configuration'>
        <table{borders}>
          <!-- begin show_categories -->
          <thead>
            <tr class='header'>
              <td colspan='5'>
                <a href='#'>{action}</a>
              </td>
              <td style='width:90%'>
                <a href='#'>{category_name}</a>
              </td>
              <td>
                <a href='#'>{id}</a>
              </td>
            </tr>
          </thead>
          <tbody>
            <!-- begin item -->
            <tr class='record{number}'>            
              <td>
                <input type='checkbox' />
              </td>
              <td>
                <a href='{link_edit}'>
                  <img src='{.template_path}img/edit.png' alt='edit' />
                </a>                           
              </td>
              <td>
                <a href='{link_delete}'>
                  <img src='{.template_path}img/delete.png' alt='delete' />                
                </a>
              </td>
              <td>
                <a href='{link_up}'>
                  <img src='{.template_path}img/up.png' title='{up}' alt='{up}' />
                </a>
              </td>
              <td>
                <a href='{link_down}'>
                  <img src='{.template_path}img/down.png' title='{down}' alt='{down}' />
                </a>
              </td>
              <td>{value}</td>
              <td>{item_id}</td>           
            </tr>          
            <!-- end item -->
          </tbody>
        </table>
        <table>
        <!-- end show_categories -->
        <!-- begin select -->
          <tr>
            <!-- begin label -->
            <td>
              <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
            </td>
            <!-- end label -->
            <td>
              <select id='{name}' name='{name}'>
              <!-- begin item -->
                <option value='{value}'{selected}>{description}</option>
              <!-- end item -->
              </select>
            </td>
          </tr>
          <!-- end select -->
          <!-- begin field -->
          <tr>
            <!-- begin label -->
            <td><label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label></td>
            <!-- end label -->
            <td><input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} /></td>
          </tr>
          <!-- end field -->          
          <!-- begin horizontal_buttons -->
          <tr>
            <td>
            <!-- begin select -->
             <!-- begin label -->
               <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label>
             <!-- end label -->
             <select id='{name}' name='{name}'>
              <!-- begin item -->
               <option value='{value}'{selected}>{description}</option>
              <!-- end item -->
            </select>
            <!-- end select -->
            <!-- begin field -->
              <!-- begin label -->
              <label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label>
              <!-- end label -->
              <input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} />          
            <!-- end field -->
            </td>
          </tr>          
          <!-- end horizontal_buttons -->
          <!-- begin add_categories -->
          <tr class='add_categories'><td colspan='2'></td></tr>          
          <!-- begin select -->
          <tr>
            <!-- begin label -->
            <td>
              <label accesskey='{key}' for='{name}'><strong>{first}</strong>{last}</label>
            </td>
            <!-- end label -->
            <td>
              <select id='{name}' name='{name}'>
              <!-- begin item -->
                <option value='{value}'{selected}>{description}</option>
              <!-- end item -->
              </select>
            </td>
          </tr>
          <!-- end select -->
        
          <!-- begin field -->
          <tr>
            <!-- begin label -->
            <td><label for='{name}' accesskey='{key}'><strong>{first}</strong>{last}</label></td>
            <!-- end label -->
            <td><input type='{type}' id='{name}' name='{name}' value='{value}'{checked}{readonly} /></td>
          </tr>
          <!-- end field -->
          
          <!-- end add_categories -->
        </table>
      </fieldset>
    </form>
    <!-- end configuration -->
    <!-- begin rss2 -->
    <h1>{title}</h1>
    <p>{rss2_generated}</p>
    <!-- end rss2 -->
  </div>
  
  <!-- end right_column -->  
  <!-- begin left_column -->
  <div  id='left'>
    <!-- begin menu -->
    <ul class='menu'>
    <!-- begin parent -->
      <li class='parent{selectedCss}'>
        <!-- begin clickable_parent -->
        <a href='{link}'><i class="fa {icon}"></i> {title}</a>
        <!-- end clickable_parent -->
        <!-- begin readonly_parent -->
        <span><i class="fa {icon}"></i> {title}</span>
        <!-- end readonly_parent -->
        <!-- begin container -->
        <ul class='container'>
          <!-- begin clickable_item -->
          <li><a href='{link}'>{title}</a></li>
          <!-- end clickable_item -->
          <!-- begin readonly_item -->
          <li>{title}</li>
          <!-- end readonly_item -->
        </ul>      
        <!-- end container -->
      </li>
      <!-- end parent -->
    </ul>
    <!-- end menu -->    
  </div>
  <!-- end left_column -->
</body>
</html>
