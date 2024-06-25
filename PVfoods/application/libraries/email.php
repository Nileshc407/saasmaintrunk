<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xml:lang="en" lang="en">

<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="initial-scale=1, user-scalable=no" />
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <style>
    table, td, div, h1, p {
      font-family: $Font_family;
    }
    @media screen and (max-width: 530px) {
      .unsub {
        display: block;
        padding: 8px;
        margin-top: 14px;
        border-radius: 6px;
        background-color: #555555;
        text-decoration: none !important;
        font-weight: bold;
      }
      .col-lge {
        max-width: 100% !important;
      }
    }
    @media screen and (min-width: 531px) {
      .col-sml {
        max-width: 27% !important;
      }
      .col-lge {
        max-width: 73% !important;
      }
    }
  </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:$Email_background_color;" background="$Body_image">
  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:$Email_background_color;font-size: $Email_font_size;color:$Email_font_color;background-image: url($Body_image);background-repeat:no-repeat;background-position: center;background-size: cover;" background="$Body_image">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;" align="center">
      <tr>
        <td align="center" style="padding:0;">         
          <table role="presentation" style="width:$Body_structure;border:none;border-spacing:0;text-align:left;line-height:22px;margin-bottom: 50px;margin-top: 50px;">
            <tr>
              <td style="padding:40px 30px 30px 30px;text-align:center;font-weight:bold;background: $Header_background_color;">
				<?php if($Email_header_image){ ?>
						<a href="#" style="text-decoration:none;"><img src=$Email_header_image width="165" alt="Logo" style="width:80%;max-width:165px;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
				<?php }  ?>
                
				<?php if($Email_header){ ?>
					<p> $email_header</p>
					
				<?php }  ?>
					
              </td>
            </tr>
            <tr>
              <td style="padding:5%;background-color:$Email_Contents_background_color;">
					$email_content
              </td>
            </tr>
            <!--<tr>
              <td style="padding:35px 30px 11px 30px;font-size:0;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
               <div class="col-sml" style="display:inline;width:100%;max-width:145px;vertical-align:top;text-align:left;font-family:Arial,sans-serif;font-size:14px;color:#363636;">
                  
               <div class="col-lge" style="display:inline;width:100%;max-width:395px;vertical-align:top;padding-bottom:20px;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                  
                  <p style="margin:0;text-align:center"><a href="#" style="background: #ff3884; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#ff3884">
				  <span style="mso-text-raise:10pt;font-weight:bold;">Activate Account</span>
				  </a></p>
                </div>
              </td>
            </tr>-->
            <tr>
              <td style="padding:30px;text-align:center;background: $Footer_background_color;color:$Footer_font_color;">
                
				<p style="margin:0 0 8px 0;">
        
          <?php if($Facebook_share_flag ==1) { ?>
            <a href="$facebook_link" style="text-decoration:none;"><img src="http://novacomonline.ehpdemo.online/images/facebook_1.webp" width="40" height="40" alt="f" style="display:inline-block;color:$Footer_font_color;"></a> 
          <?php  } ?>
          <?php if($Twitter_share_flag ==1) { ?>
          <a href="$twitter_link" style="text-decoration:none;"><img src="http://novacomonline.ehpdemo.online/images/twitter_1.webp" width="40" height="40" alt="t" style="display:inline-block;color:$Footer_font_color;"></a>
          <?php  } ?>
          <?php if($Google_share_flag ==1) { ?>
          <a href="$googlplus_link" style="text-decoration:none;"><img src="http://novacomonline.ehpdemo.online/images/twitter_1.webp" width="40" height="40" alt="t" style="display:inline-block;color:$Footer_font_color;"></a>
          <?php  } ?>
          <?php if($Linkedin_share_flag ==1) { ?>
          <a href="$linkedin_link" style="text-decoration:none;"><img src="http://novacomonline.ehpdemo.online/images/twitter_1.webp" width="40" height="40" alt="t" style="display:inline-block;color:$Footer_font_color;"></a>
          <?php  } ?>
          
        </p>

          <!--<p style="margin:0;font-size:14px;line-height:20px;">&reg; Novacom, Novacom 2021<br> -->
          <?php if($Unsubscribe_flg ==1) { ?>
           <p style="margin:0;font-size:14px;line-height:20px;"> <a class="unsub" href="#" style="color:$Footer_font_color;text-decoration:underline;">Unsubscribe</a></p>
          <?php  } ?>
				$email_footer
				
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>