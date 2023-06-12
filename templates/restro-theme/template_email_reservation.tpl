<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{SITE_TITLE}</title>
    <style>
        .menu_title
        {
          font-size:12px;color:#363636;padding-left:10px;
        }
        .menu_extra{
            font-weight:bold;color:{BACKGROUND};margin:0;
        } 
        .text_style_center
        {
            font-size:12px;color:#363636;text-align: center;
        }
        .menu_total_price
        {
            border-right:#cecece 1px solid;padding-right: 10px;font-size:12px;color:#363636;text-align: right;
        }
        .table_order_detail td {border-bottom:#cecece 1px solid;
            border-left:#cecece 1px solid;padding-left:10px;padding-right:10px;}

        .email_order_content
        {
            margin-top: 10px;
        }
        td
        {
            font-family: Roboto;
        }
      </style>
</head>
<body>
<br>

<div style="font-family: Roboto;letter-spacing:1px;line-height: 20px;" id="main-section">
    <div class="container">
        <div class="fl full-container">
            <div id="mainContainer">
                <div style="padding:0 0 50px 0">
                    <div class="row no-mar block-bot-space">
                        <div class="container clearfix dc">
                            <div style="width:100%;height:100px;" class="email-header">
                                <div style="text-align: center;" id="email-logo">      
                                    <img style="height:80px;width:auto;margin-right:10px;margin-top:10px;"
                                    src="{MAIN_IMAGE}" alt="{SHOP_NAME}">
                                </div>   
                            </div>
                            <div style="text-align: center;margin-top:20px;" class="title">
                                <h1 style="color: black;font-weight: 500;margin: 0;padding:0;letter-spacing:1px;line-height: 20px;font-size: 14px;" class="title-top-space">Hallo {CUSTOMER_NAME}</h1>
                                <h1 style="color: black;font-weight: 500;margin: 0;padding: 0;letter-spacing:1px;font-size: 14px;"  class="title-top-space"> Vielen Dank für Dein Bestellung</h1>
                                <p  style="font-size: 12px;margin-top:20px;">Wir haben Deine Bestellung erhalten. Bei Fragen kannst du unter  <span style="color:{BACKGROUND};">{SHOP_TELEPHONE}</span> anzurufen</p>
                            </div>
                            <div style="background-color: #F2F2F2; padding:10px 20px;margin-top:10px;">
                               <h3 style="color: {BACKGROUND};font-weight: 500;margin: 0;padding: 0;font-size: 14px;" >Terminstatus: <span style="font-weight: bold;">{RESERVATIONS_STATUS_TEXT}</span></h3>  
                         
                               IF("{RESERVATIONS_STAFF}" != ""){
                                <h3 style="color: {BACKGROUND};font-weight: 500;margin: 0;padding: 0;font-size: 14px;" >Mitarbeiter: <span style="font-weight: bold;">{RESERVATIONS_STAFF}</span></h3> 
                                {:IF}

                               IF("{RESERVATIONS_STATUS_CODE}" == '2'){
                               <h3 style="color: {BACKGROUND};font-weight: 500;margin: 0;padding: 0;font-size: 14px;" >Stornierungsgrund: <span style="font-weight: bold;">{RESERVATIONS_CANCEL_REASON_TEXT}</span></h3> 
                               {:IF}
                                  
                            </div>
                            <div  class="email_order_content">         
                         
                              <table class="table_order_detail" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr bgcolor="{BACKGROUND}">
                                        <td width="60%" height="40"><div align="left" style="font-size:12px;color:#ffffff;border-left:{BACKGROUND} 5px solid">Dienstleistungen</div></td>
                                        <td width="20%" height="40" style="border-left:#939393 1px solid"><div align="right" style="font-size:12px;color:#ffffff">Preis</div></td>
                                        <td width="20%" height="40" style="border-left:#939393 1px solid"><div align="right" style="font-size:12px;color:#ffffff;border-right:{BACKGROUND} 5px solid">Minute</div></td>
                                    </tr>
                                    {RESERVATIONS_DETAIL}
                                </tbody>
                            </table>
                             </div>
                             <div style="background-color: #F2F2F2; padding:10px 20px;margin-top: 10px;line-height: 20px;" class="email-order-payment-methoad">                    
                                IF("{RABATT_CODE}" != ''){
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">Rabattcode <span style="font-weight: bold;float: right;">{RABATT_CODE}</span></h3> 
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">Ermäßigungsbetrag <span style="font-weight: bold;float: right;">{RABATT_COST}</span></h3>
                                {:IF}
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">Zahlungsarten <span style="font-weight: bold;float: right;">{PAYMENT_METHOAD}</span></h3>  
                            </div>
                            <div style="background-color: {BACKGROUND}; padding:20px 20px;margin-top: 10px;">
                                <h2 style="color:white;font-weight: 500;margin: 0;padding: 0;font-size: 16px;">GesamtSumme <span style="font-weight: bold;float: right;">{TOTAL_SUM}</span></h2>
                            </div>
                            <div style="margin-top:15px;" class="customer_info">
                                <h2 style="font-weight: bold;font-size: 14px;">Bestellinformationen</h2>

                                <table style="width: 100%;margin-top: 15px;font-size: 12px;line-height: 18px;">
                                    <tr>
                                        <td style="width:40%;">Name der Kunden:</td>
                                        <td>{CUSTOMER_NAME}</td>
                                    </tr>
                            
                                    <tr>
                                        <td style="width:40%;">Telefon Nr.:</td>
                                        <td>{CUSTOMER_TELEPHONE}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:40%;">E-Mail:</td>
                                        <td>{CUSTOMER_EMAIL}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:40%;">Datum:</td>
                                        <td >{DATE_BOOKING} | <span style="color: {BACKGROUND};">Schnellstmöglich</span> </td>
                                    </tr>
                                    IF("{RESERVATIONS_STATUS_CODE}" == '0'){
                                    <tr>
                                        <td style="width:40%;">Stornieren:</td>
                                        <td >Sie können Ihren Termin jederzeit stornieren, indem Sie uns unter der Telefonnummer {SHOP_TELEPHONE} kontaktieren oder auf diesen Link klicken: {LINK_CANCELLED_BOOKING}</td>
                                    </tr>
                                    {:IF}

                                </table>
                            </div>
                            <div  style="height: 1px;width:100%;border-top:dotted 2px;margin-top:20px"></div>

                            <div style="margin-top:20px;" class="footer">            
                                <p style="font-size: 12px;">Vielen Dank für Ihre Reservierung. Wir möchten Ihnen hiermit bestätigen, dass Ihre Reservierung erfolgreich abgeschlossen wurde. Wir freuen uns darauf, Sie bei uns begrüßen zu dürfen! </p>
                            </div>
                            <div class="customer_info">
                                <h2  style="font-weight: bold;margin: 0;padding: 0;font-size: 12px;">{SHOP_NAME}</h2>
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">{SHOP_ADDRESS}</h3>
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">{SHOP_TELEPHONE}</h3>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>