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
                                    <img style="height:80px;width:auto;margin-right:10px;margin-top:10px;" class="restaurant-logo"
                                    src="{SITE_URL}storage/restaurant/logo/{MAIN_IMAGE}" alt="{RESTAURANT_NAME}">
                                </div>   
                            </div>
                            <div style="text-align: center;margin-top:20px;" class="title">
                                <h1 style="color: black;font-weight: 500;margin: 0;padding:0;letter-spacing:1px;line-height: 20px;font-size: 14px;" class="title-top-space">Hallo {RESTAURANT_NAME}</h1>
                                <h1 style="color: black;font-weight: 500;margin: 0;padding: 0;letter-spacing:1px;font-size: 14px;"  class="title-top-space"> Vielen Dank für Dein Bestellung</h1>
                                <p  style="font-size: 12px;margin-top:20px;">Ihre Daten werden nun von einem unserer Mitarbeiter überprüft. Hierzu werden Sie gegebenenfalls E-Mail kontaktiert, um ihre angegebenen bestellte Modul zu validieren</p>
                            </div>
                            <div style="background-color: #F2F2F2; padding:10px 20px;margin-top:10px;">
                                <h3 style="color: {BACKGROUND};font-weight: 500;margin: 0;padding: 0;font-size: 14px">Bestelldatum <span style="font-weight: bold;float: right;">{ORDER_DATE}</span></h3> 
                            </div>

                            <div style="background-color: #F2F2F2; padding:10px 20px;margin-top:10px;">
                               <h3 style="color: {BACKGROUND};font-weight: 500;margin: 0;padding: 0;font-size: 14px;" >Bestellnummer: <span style="font-weight: bold;">{ORDER_ID}</span></h3>      
                            </div>
                            <div  class="email_order_content">         
                         
                              <table class="table_order_detail" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr bgcolor="{BACKGROUND}">
                                        <td width="40%" height="40"><div align="left" style="font-size:12px;color:#ffffff;border-left:{BACKGROUND} 5px solid">Modulname</div></td>
                                        <td width="60%" height="40" style="border-left:#939393 1px solid"><div align="left" style="font-size:12px;color:#ffffff;border-right:{BACKGROUND} 5px solid">Detail</div></td>
                                    </tr>
                               <tr>
                                <td class="menu_title" style="vertical-align: top;padding-top: 12px;" height="40">{MODULL_NAME}</td>
                                <td><p> Vertragslaufzeit: {DATE_EXPIRES}</p>
                                    <p> Abrechnungszeitraum: {PAYMENT_TERM}</p>
                                    <p> Installationskosten: {INSTALL_AMOUNT}</p>
                                    <p> Betrag: {AMOUNT}</p>        
                                </td>
                               </tr>
                            </tbody></table>
                          
                             </div>

                             <div style="background-color: #F2F2F2; padding:10px 20px;margin-top: 10px;line-height: 20px;" class="email-order-payment-methoad">
                                <h3 style="font-weight: 500;margin: 0;padding: 0;font-size: 12px;">Zahlungsarten <span style="font-weight: bold;float: right;">{PAYMENT_METHOAD}</span></h3>  
                            </div>

                            <div style="background-color: {BACKGROUND}; padding:20px 20px;margin-top: 10px;">
                            
                                <h2 style="color:white;font-weight: 500;margin: 0;padding: 0;font-size: 16px;">19% MwSt. <span style="font-weight: bold;float: right;">{TOTAL_TAX_AMOUNT}</span></h2>

                                <h2 style="color:white;font-weight: 500;margin: 0;padding: 0;font-size: 16px;">Gesamtsumme <span style="font-weight: bold;float: right;">{TOTAL_SUM}</span></h2>
                            </div>
                            <div style="margin-top:15px;" class="customer_info">
                                <h2 style="font-weight: bold;font-size: 14px;">Bestellinformationen</h2>

                                <table style="width: 100%;margin-top: 15px;font-size: 12px;line-height: 18px;">
                                    <tr>
                                        <td style="width:40%;">Name der Kunden:</td>
                                        <td>{RESTAURANT_NAME}</td>
                                    </tr>
                                    IF("{RESTAURANT_ADDRESS}" != ''){
                                    <tr>
                                        <td style="width:40%;">Adresse:</td>
                                        <td>{RESTAURANT_ADDRESS}</td>
                                    </tr>
                                    {:IF}
                                  
                                    <tr>
                                        <td style="width:40%;">Kunden Nr.:</td>
                                        <td >{RESTAURANT_ID}</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="width:40%;">Telefon Nr.:</td>
                                        <td>{RESTAURANT_TELEPHONE}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:40%;">E-Mail:</td>
                                        <td>{RESTAURANT_EMAIL}</td>
                                    </tr>
                               
                                </table>
                            </div>
                            <div  style="height: 1px;width:100%;border-top:dotted 2px;margin-top:20px"></div>

                            <div class="companny_info">
                                <h5  style="font-weight: bold;margin: 0;padding: 0;font-size: 12px;text-align: center;">{SITE_TITLE}  | {SITE_ADDRESS} | 97084 Würzburg | d-gastro24.de | {SITE_EMAIL}</h5>
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