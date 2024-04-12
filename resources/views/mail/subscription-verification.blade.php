<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="background-color:#eee">

  <table border="0" cellpadding="0" cellspacing="0" width="100%"
      style="table-layout:fixed;background-color:#eee" id="bodyTable">
      <tbody>
          <tr>
              <td align="center" valign="top" style="padding-right:10px;padding-left:10px" id="bodyCell">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperTable"
                      style="max-width:600px">
                      <tbody>
                          <tr>
                              <td align="center" valign="top">
                                  <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                      class="oneColumn" style="background-color:#fff">
                                      <tbody>
                                          <tr>
                                              <td align="center" valign="top" style="padding-bottom:40px"
                                                  class="imgPost"><a href="#"
                                                      style="text-decoration:none"><img alt=""
                                                          border="0"
                                                          src="{{ asset('uploads/subscribe.png') }}"
                                                          style="width:100%;max-width:600px;height:auto;display:block"
                                                          width="600"></a></td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="top"
                                                  style="padding-bottom:20px;padding-left:20px;padding-right:20px"
                                                  class="title">
                                                  <h2 class="bigTitle"
                                                      style="color:#313131;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:26px;font-weight:600;font-style:normal;letter-spacing:normal;line-height:34px;text-align:center;padding:0;margin:0">
                                                      Verify Your Email</h2>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="top" style="padding-bottom:20px">
                                                  <table border="0" cellpadding="0" cellspacing="0"
                                                      width="50" class="divider" align="center">
                                                      <tbody>
                                                          <tr>
                                                              <td align="center"
                                                                  style="border-bottom:2px solid #8d6cd1;font-size:0;line-height:0">
                                                                  &nbsp;</td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="top"
                                                  style="padding-bottom:20px;padding-left:20px;padding-right:20px"
                                                  class="description">
                                                  <p class="midText"
                                                      style="color:#919191;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;line-height:20px;text-align:center;padding:0;margin:0">
                                                      Thanks for signing up for the Shopnest newsletter. Please
                                                      click Confirm button for subscription to start receiving our
                                                      emails.<br><br></p>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="top"
                                                  style="padding-bottom:40px;padding-left:20px;padding-right:20px"
                                                  class="btn-card">
                                                  <table border="0" cellpadding="0" cellspacing="0"
                                                      align="center">
                                                      <tbody>
                                                          <tr>
                                                              <td align="center"
                                                                  style="background-color:#8d6cd1;padding-top:10px;padding-bottom:10px;padding-left:25px;padding-right:25px;border-radius:2px"
                                                                  class="postButton"><a href="{{ route('newsletter-verify', $subscriber->verified_token) }}"
                                                                      style="color:#fff;font-family:'Open Sans',Helvetica,Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block">Confirm
                                                                      Email</a></td>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </td>
          </tr>
      </tbody>
  </table>
</body>

</html>
