<base href="{{ asset('') }}">
<div marginheight="0" marginwidth="0" style="background:#f0f0f0">
    <div id="wrapper" style="background-color:#f0f0f0">

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
            style="margin:0 auto;width:600px!important;min-width:600px!important" class="container">
            <tbody>
                <tr>
                    <td align="center" valign="middle" style="background:#ffffff">
                        <table style="width:580px;border-bottom:1px solid #007de0" cellpadding="0" cellspacing="0"
                            border="0">
                            <tbody>
                                <tr>
                                    <td align="left" valign="middle" style="width:auto;height:60px">
                                        <a href="#" style="border:0" target="_blank" height="30"
                                            style="display:block;border:0px">
                                            <img src="http://holomia.com/arena/public/images/logo_holomia.png"
                                                height="30" style="display:block;border:0px;float: left;"> <b
                                                style="float: left;line-height: 100px;color: red;font-size: 20px;"></b>
                                        </a>
                                    </td>
                                    <td align="right" valign="middle" style="padding-right:15px; with:800px;">
                                        Created date: <?php echo date('Y/m/d'); ?><br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="background:#ffffff">
                        <table style="width:580px" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td align="left" valign="middle"
                                        style="font-family:Arial,Helvetica,sans-serif;font-size:24px;color:#007de0;text-transform:uppercase;font-weight:bold;padding:25px 10px 15px 10px">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="middle"
                                        style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;padding:0 10px 20px 10px;line-height:17px">
                                        <h1>Welcome to MissionX - VR Laser Tag! </h1>
                                        <p>Finish setting up by activating your demo account.</p>
                                        <p>Time: <?php echo date('Y/m/d'); ?></p>
                                        <p>Located: {{ $contact->located }}</p>
                                        <p>Name: {{ $contact->name }}</p>
                                        <p>Email: {{ $contact->email }}</p>
                                      
                                    </td>
                                <tr>
                                    <td align="left" valign="middle"
                                        style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666666;padding:0 10px 20px 10px;line-height:17px">
                                        <form class="input-transparent" role="form" action="commercial/confirm"
                                            method="GET">
                                            {{ csrf_field() }}
                                            <input type="hidden" class="form-control border-secondary" name="name"
                                                value="{{ $contact->name }}">
                                            <input type="hidden" class="form-control border-secondary" name="email"
                                                value="{{ $contact->email }}">
                                         
                                            <button type="submit" class="btn" style="border: 0px;
                                                                background: #007de0;
                                                                text-decoration: none;
                                                                border-radius: 5px;
                                                                padding: 10px;    margin-left: 30%;
                                                                color: white;" target="_blank">
                                                Click here to activate Your Account
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                </tr>
            </tbody>
        </table>
        </td>
        </tr>
        <tr>
            <td align="center" valign="middle" style="background:#ffffff;padding-top:20px">
                <table style="width:500px" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td align="center" valign="middle"
                                style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">
                                <br> Have questions?
                                You can check out our FAQ or our support page for more information:
                                <a href="#"
                                    style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#0066cc;text-decoration:none;font-weight:bold"
                                    target="_blank">
                                    https://www.facebook.com/missionxvr/
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    var csrfToken = $('[name="csrf_token']).attr('content');
    setInterval(refreshToken, 3600000);

    function refreshToken() {
        $.get('refresh-csrf').done(function(data) {
            csrfToken = data;
            // the new token
        });
    }
    setInterval(refreshToken, 3600000); // 1 hour

</script>
