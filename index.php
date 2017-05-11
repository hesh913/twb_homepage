<?php $step = isset( $_GET['step'] ) ? $_GET['step'] : "check"; $app_name = "SeventyTwo" ?>
<!DOCTYPE html>
<html>
<head>
  <title>Installation Guide</title>
  <meta charset="utf-8">
  <meta name="author" content="Choco Pixel">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://choco-pixel.com/docs/css/main.css" type="text/css">
  <link rel="stylesheet" href="php/installer/style.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
  <header>
    <a href="http://choco-pixel.com">
      <img width="60" height="60" title="" alt="Choco Pixel" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AQEEC8HMCyOCwAAAwlJREFUaN7tmU9IVFEUh79JqSBM+kOgEVEQZUi1uJgEgrsQCuvSIgLBFlnQwhaBcBdtgksQQUUERouCyFaXlCAIgpQIglsQFpYiIVFGmwjKnDCnhbeYxnnPGSea6/P+YBh4582Z971z3nn3nJuySk4AS1gcmq50sMsWCXB6sUT2jwJwAA7AATgAB+AAHIADcAAOwAE4AAfgAByAA3AADsCeq3KBXOd3YNJdb1USgfuBW8CA0GY412iVXAc0AhJoKyZTfUvpq8BqoU0zcD0fLIDQ5hPQJ7RpF9pUACdcFsyplFVykvLvPHwEGoU2Y6U4sUpeA47FnOLFzsMDoU0NMFaqI6FNB3DE55TuFdrstUoitPknDoU2PUCTb8AZYEhoc8Bd5HzSN/K40OYxYH2q0ilAREXWKpkS2mSskm1AO7AbWOHMX4AnQDfQm+tDaINVsg8QPgF3Cm0mYuy7rJKPgJV5bNVAC9BilfwANAMjWTfrIrDfp5T+KbS5HJOqh4HnEbC5qgWGrZKt7rcngU7fFh7nY57JHUDPPHzetUoeB674uPC4E1FdAe6X4Lfby6Wl0OZFRHT3uBRNVLc0EhPd1iS2h+9ibDuTCPw1xladROC4mpFOIvDaGNvbJAJviXkH9ycReJVVcnlElb6ZRGCAg/k6HaFNBrhQgt8fvgJ3RLWDQpvT7tWVKdLnWaAGmPIRuNkquSFflN2xzcBwEf5OCW3OAJ+BjXPdrHINAG7ni7I7NiW02QZ0MTOajdI9oFZocynrkRh30NGNeBmHeEeFNjcKmGw0uC6qCvgGjAptHmZNN2YND4BNwCsgt0Cmyz21rAPeuOjEjnPcJKOgcZBVsh54BizNBS73EG8I2F5Ah/XX9xywTcBgHtiyPsPZemmV7MgqWkXr9++skl3AgI9Fa1bzbpV86ip0weBZ5221Sg4C53x8LUWpARi1Sg4Ah/KtyPJonxv2vQbqC/kTX7ZaovTeVdtxZvaOKoA1rtjVzcNf2vft0vXus6DX0mVVAE66KoHp/zVe8UDTvwAHV/Sc7ceN0AAAAABJRU5ErkJggg==" />
    </a>
  </header>
  <main>
     <?php
       switch($step) {

         case "check":
            $error = array(false, false, false);
            $php_version = $mail_func = $writing = '';

            if(version_compare(PHP_VERSION, '5.3.0') >= 0){
              $php_version = '<span class="text-success">' . phpversion() . ' &#10004;</span>';
            } else {
              $php_version = '<span class="text-danger">PHP version must be greater than 5.3.0 &#10005;</span>';
              $error[0] = true;
            }

            if(function_exists('mail')){
              $mail_func = '<span class="text-success">Enabled &#10004;</span>';
            } else{
              $mail_func = '<span class="text-danger">Enable/Check mail() function &#10005;</span>';
              $error[1] = true;
            }

            if(is_writable(__FILE__)){
              $writing = '<span class="text-success">Enabled &#10004;</span>';
            } else{
              $writing = '<span class="text-danger">Disabled &#10005;</span>';
              $error[2] = true;
            }

           ?>
           <div class="row">
             <div class="col-xs-12">
               <h3>Installation of <?php echo $app_name; ?></h3>
             </div>
           </div>
          <form action="" id="check" data-step="option" class="form-step">
            <div class="row">
              <div class="col-xs-12">
                <strong>Server info:</strong>
                <ul>
                  <li>PHP version: <?php echo $php_version; ?></li>
                  <li>Mail function: <?php echo $mail_func; ?></li>
                  <li>Writing enabled: <?php echo $writing; ?></li>
                </ul>
              </div>
            </div>
            <button type="submit" class="btn btn-default <?php echo (count(array_unique($error)) === 1 ? "" : "disabled"); ?>">Next </button>
          </form>

           <?php

         break;

         case "option":
           ?>
             <div class="row">
               <div class="col-xs-12">
                 <h3>Choose option</h3>
               </div>
             </div>

             <div class="row">
               <div class="col-xs-12">
                 <form action="" id="option" data-step="" class="form-step">
                   <div class="form-group">
                     <label for="install_option">Choose your option installation:</label>
                     <select class="form-control" name="variant" id="variant">
                      <option value=""></option>
                       <option value="db">Database</option>
                       <option value="mailchimp">MailChimp</option>
                     </select>
                   </div>
                   <button type="submit" class="btn btn-default" disabled="true">Next</button>
                 </form>
               </div>
             </div>
           <?php
         break;

         case "db":

         ?>

         <div class="row">
           <div class="col-xs-12">
             <h3>Database installation</h3>
           </div>
         </div>

         <form action="" id="db" data-step="contact" class="form-step">
           <table class="form-table">
             <tbody>
               <tr class="form-group">
                 <th scope="row"><label for="database_host" class="control-label">Database Host</label></th>
                 <td>
                   <input name="database_host" id="database_host" type="text" size="25" placeholder="Enter database host" class="form-control" required>
                 </td>
                 <td>you should be able to get this info from your web host, if <code>localhost</code> does not work</td>
               </tr>
               <tr>
           			<th scope="row"><label for="database_name">Database Name</label></th>
           			<td>
                    <input name="database_name" id="database_name" type="text" size="25" placeholder="Enter database name" class="form-control" required>
                </td>
           			<td>the name of the database you want to run <?php echo $app_name; ?> in</td>
           		</tr>
           		<tr>
           			<th scope="row"><label for="database_username">User Name</label></th>
           			<td><input name="database_username" id="database_username" type="text" size="25" placeholder="Enter database username" class="form-control" required></td>
           			<td>your MySQL username</td>
           		</tr>
           		<tr>
           			<th scope="row"><label for="database_password">Password</label></th>
           			<td><input name="database_password" id="database_password" type="password" size="25" placeholder="Enter database password" autocomplete="off" class="form-control" required></td>
           			<td>your MySQL password</td>
           		</tr>
             </tbody>
           </table>

           <div class="row">
             <div class="col-xs-12">
               <button type="submit" class="btn btn-default" name="submit" >Next</button>
             </div>
           </div>
         </form>
     <?php
       break;

       case "mailchimp":
         ?>

         <div class="row">
           <div class="col-sm-12">
             <h3>MailChimp Installation</h3>
           </div>
         </div>

         <form action="" id="mailchimp" data-step="contact" class="form-step">
           <table class="form-table">
             <tbody>
               <tr>
                 <th scope="row"><label for="list_id">List ID</label></th>
                 <td><input name="list_id" id="list_id" type="text" size="25" placeholder="Enter list ID" class="form-control" required></td>
                 <td>You should be able to get this info from your web host, if <code>localhost</code> doesn’t work.</td>
               </tr>
               <tr>
           			<th scope="row"><label for="api_key">API Key</label></th>
           			<td><input name="api_key" id="api_key" type="text" size="25" placeholder="Enter API KEY" class="form-control" required></td>
           			<td>The name of the database you want to run WP in.</td>
           		</tr>
             </tbody>
           </table>

           <div class="row">
             <div class="col-sm-12">
               <button type="submit" class="btn btn-default" name="submit">Next</button>
             </div>
           </div>
         </form>

         <?php

       break;

       case "contact":

         ?>

         <div class="row">
           <div class="col-sm-12">
             <h3>Contact Email</h3>
           </div>
         </div>

         <form action="" id="contact" data-step="finish" class="form-step">
           <div class="row">
             <div class="col-sm-12">
                 <table class="form-table">
                   <tbody>
                     <tr>
                       <th><label for="contact_email">Contact E-mail</label></th>
                       <td><input name="contact_email" id="contact_email" type="text" size="25" placeholder="email@mydomain.com" class="form-control" required></td>
                       <td>e-mail address you want to receive the messages from contact form</td>
                     </tr>
                     <tr>
                 			<th><label for="contact_subject">Subject</label></th>
                 			<td><input name="contact_subject" id="contact_subject" type="text" size="25" placeholder="Website contact form" class="form-control" required></td>
                 			<td>subject to be shown in your received e-mails from contact form</td>
                 		</tr>
                   </tbody>
                 </table>
             </div>
           </div>

           <div class="row">
             <div class="col-sm-12">
               <button type="submit" class="btn btn-default" name="submit">Next</button>
             </div>
           </div>
         </form>

         <?php

       break;

       case "finish":

         ?>
         <div class="row">
           <div class="col-sm-12">
             <h3>Ready to launch</h3>
           </div>
         </div>

         <form method="post" id="finish" data-step="clean" class="form-step">
           <div class="row">
             <div class="col-sm-12">
                 <p>All right! You’ve made it through the installation. You can freely go to your freshly set up SeventyFive template.</p>
             </div>
           </div>

           <div class="row">
             <div class="col-sm-12">
               <button type="submit" class="btn btn-default" name="submit">Go to website</button>
             </div>
           </div>
          </form>

         <?php

         break;

        case "clean":

          $dir = dirname(__FILE__);
          $installer_dir = '/php/installer';

          array_map('unlink', glob($dir . $installer_dir . '/*'));
          rmdir($dir . $installer_dir );
          rename($dir . '/_index.html', $dir . '/index.html');

          unlink(__FILE__);

          header("Location: index.html");

        break;
     }
     ?>

   </main>

  <footer>
    <small>&copy; <a href="http://choco-pixel.com">Choco Pixel</a> | <?php echo $app_name; ?></small>
  </footer>

  <script>
  (function($){

    var url = "index.php?step=";

    $.ajaxSetup({
      url: "php/installer/ajax-setup.php",
      type: "POST"
    });

    $("#variant").on("change", function(event){
      if($(this).val() !== ""){
        var $form = $(this).closest("form[data-step]");
        $form.attr("data-step", $(this).val());
        $form.find("button[type='submit']").prop('disabled', false);
      }
    });

    function sendData(id, data, stepUrl) {
      $.ajax({
        data: 'step='+ id + '&' +  data,
        dataType: 'text'
      })
      .done(function(res) {
        if(res.length > 0){
          res = $.parseJSON(res);
          var $alertRow = $(".alert-row");
          if($alertRow.length > 0){
            var $alertBox = $alertRow.find(".alert");
            if(res.type === -1){
              $alertBox.addClass("alert-danger");
            }
            $alertBox.html("<strong>Error!</strong> " + res.message);
            $alertRow.show();
          }
        } else {
          window.location = url + stepUrl;
        }
      })
      .fail(function (xhr, ajaxOptions, thrownError) {
        console.error(xhr, thrownError);
      });
    }

    $("form[data-step]").on("submit", function(event){
      event.preventDefault();
      $(this).find("button[type='submit']").prop('disabled', true);
      var step = $(this).attr("data-step");
      var id = $(this).attr("id");
      var data = $( this ).serialize();

      sendData(id, data, step);
    });

    var alertBox = [
      '<div class="row alert-row" style="display: none;">',
        '<div class="col-xs-12">',
          '<div class="alert" role="alert"></div>',
        '</div>',
      '</div>'
    ].join("");

    $("form[data-step]").before(alertBox);

  }(jQuery));
  </script>
</body>
</html>
