<!DOCTYPE html>
<html  lang="{LANG_CODE}" dir="{LANGUAGE_DIRECTION}" data-menu="classicmenu">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

    <meta name="author" content="{SITE_TITLE}">
    <meta name="keywords" content="{PAGE_META_KEYWORDS}">
    <meta name="description" content="{PAGE_META_DESCRIPTION}">
	
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//google.com">
    <link rel="dns-prefetch" href="//apis.google.com">
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com">
    <link rel="dns-prefetch" href="//gstatic.com">
    <link rel="dns-prefetch" href="//oss.maxcdn.com">

    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}"/>

    <title>IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}</title>
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" href="{SITE_URL}includes/assets/css/icons.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/plugins.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/style.min.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/templete.min.css">
	
	<!--CUSTOMS FONT FACES FROM SETTINGS -->
	{CUSTOM_SETTING_FONT_FACES_AND_CLASSES}
	<!--END CUSTOMS FONT FACES FROM SETTINGS -->

	<!--customized style-->
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/shop-nail.css?v={VERSION}&t={SHOP_TIME_NOW}"/>
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/reset-and-customized.css?v={VERSION}&t={SHOP_TIME_NOW}"/>
	IF("{RESTAURANT_CHANGE_HOME_BACKGROUND_IMAGE}" == "1"){        
        <link class="skin" rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/skin/skin-3.css?v={VERSION}">
    {ELSE}
        <link class="skin" rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/skin/skin-2.css?v={VERSION}">
    {:IF}
	
	IF("{MENU_FLAT_ICON_CODE}"!=""){
	<style>
		@font-face {
			font-family: "Flaticon";
			src: url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.eot");
			src: url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticond41d.eot?#iefix") format("embedded-opentype"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.woff") format("woff"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.ttf") format("truetype"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.svg#Flaticon") format("svg");
			font-weight: normal;
			font-style: normal;
		}
		.header-nav .nav>li>a:after{
			content: "{MENU_FLAT_ICON_CODE}";
		}
	</style>
	{:IF}
	
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Alumni+Sans');
		@import url('https://fonts.googleapis.com/css?family=Dancing+Script');		
		
		:root{  
			{LOOP: CLASSIC_COLOR}--classic-color-{CLASSIC_COLOR.id}: {CLASSIC_COLOR.value};{/LOOP: CLASSIC_COLOR} 
			--menu-fore-color: {RESTAURANT_MENU_FORE_COLOR};
			--menu-color: {RESTAURANT_MENU_COLOR};
		}
		#loading-area, div.loading{
			background-repeat: no-repeat;
			background-size: 120px ,  200px;
    		background-position: center;
		}
		#loading-area{
			background-color:#FAFAFA; opacity: 0.2;
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR}),
							url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/about/loading.png) !important;
			opacity:0.9;	
		}
		div.loading, .loading{
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR}) !important;
			background-size: 60px,100px;
			min-height:50px;
		}

		button[type="button"].disabled.loading, button[type="submit"].disabled.loading{
			background-size: 42px 42px;
			background-position: center center;
			background-repeat: no-repeat;
			cursor: default;
		}

		.header-transparent .main-bar{background-color: var(--classic-color-0_3);}

		.form-msg{display: none;}
		#dzcommon-customer-form-container .input-group{margin:15px 0 !important;}
		#dzcommon-customer-form-container a{color:var(--classic-color-1);}
		#dzcommon-customer-form-container input.form-control{line-height:48px !important;height: 48px !important;}
		#dzcommon-customer-form-container .site-button{height:48px !important;}

		.input-group-append .toggle-password{
			background-color: #fff; cursor: pointer;
			color: var(--classic-color-1);font-size:20px;
		}
		.input-group-append .toggle-password:hover{
			background-color: var(--classic-color-1);color:#FFF;
		}
	</style>

	<script type="text/javascript">
		var gaCategories = [];
		var zozoneNailParams = {
			bookingSiteURI 	: '{SITE_URL}{SLUG}/booking/',
			loginSiteURI 	: '{SITE_URL}{SLUG}/login?return={RETURN_URL}',
			returnURL		: '{RETURN_URL}',
			langName	: '{CURRENT_LANGUAGE_NAME}',
			langCode	: '{CURRENT_LANGUAGE_CODE}',
			ajaxURL		: '{SITE_URL}php/?{SHOP_BOOKING_TOKEN}',
			apiKey		: '{SHOP_BOOKING_TOKEN}',
			theForm		: '{THE_REQUEST_FORM}'			
		};
	</script>
</head>
<body id="bg">
<div class="page-wraper">
<div id="loading-area"></div>
	<!-- header -->
	<header class="site-header header header-transparent mo-left onepage spa-header ">
		<!-- main header -->
        <div class="sticky-header main-bar-wraper navbar-expand-lg">
            <div class="main-bar clearfix ">
                <div class="container clearfix">
                    <!-- website logo -->
                    <div class="logo-header mostion">						
						<a href="{SITE_URL}{SLUG}" class="dez-page">
							<img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" data-src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}">
						</a>
					</div>
                    <!-- nav toggle button -->
                    <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					
					<!-- extra nav -->
                    <div class="extra-nav">
                        <div class="extra-cell">
							<div class="dzlang-menu">
								<div class="site-button scroll radius-no"><a href="javascript:;" class="dzlang-menu-btn flag-selected flag-German">German</a></div>
								<div class="dzlang-menu-content">									
									{LOOP: LANGS}
										<a href="#" class="flag-{LANGS.name}" data-lang="{LANGS.file_name}" data-code="{LANGS.code}">{LANGS.name}</a>
									{/LOOP: LANGS}
								</div>
							</div>
                        </div>
                    </div>
					
                    <!-- main nav -->
                    <div class="header-nav navbar-collapse navbar collapse justify-content-end" id="navbarNavDropdown">
						<ul class="nav navbar-nav navbar menu-font-options">	
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzhome">{LANG_HOME}</a></li>
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzaboutme">{LANG_ABOUT_ME}</a></li>
							<li>
								<a class="dez-page" href="{SITE_URL}{SLUG}#dzservices">{LANG_SERVICES} <i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									{LOOP: CAT_MENU_2} 
                                	<li><a href="{SITE_URL}{SLUG}#dzservice-{CAT_MENU_2.id}">{CAT_MENU_2.name}</a></li>  									
                                	{/LOOP: CAT_MENU_2}
								</ul>
							</li>	
							IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzportfolio">{LANG_GALLERY}</a></li>
							{:IF}
							IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzstaffs">{LANG_OUR_STAFFS}</a></li>
							{:IF}
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzcontact">{LANG_CONTACT}</a></li>
							<li><a href="{SITE_URL}{SLUG}/booking">{LANG_BOOK_NOW}</a></li>
							<!--
							IF("{LOGGED_IN}"=="1"){
								<li><a class="loginout" data-action="logout" href="#">{LANG_LOGOUT}</a></li>
							{ELSE}
							<li><a class="loginout" data-action="login" href="#">{LANG_LOGIN}</a></li>
							{:IF}
							-->
						</ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- main header END -->
    </header>
		
    <!-- header END -->
    <!-- Content -->
    <div class="page-content bg-white">
		<!-- Main Slider -->
        <div id="dzhome" style="min-height:140px"></div>
		<div class="container privacy-container">
			<div class="row">
				<div class="sidebar col-sm-3">
					<ul>
						<li class=""><a href="{SITE_URL}{SLUG}">Startseite</a></li>
						<li class="active"><a class="dez-page" href="{SITE_URL}{SLUG}/privacy#agb">AGB</a></li>
						<li><a class="dez-page" href="{SITE_URL}{SLUG}/privacy#datenschutzerklarung">Datenschutzerklärung</a></li>
						<li><a class="dez-page" href="{SITE_URL}{SLUG}/privacy#impressum">IMPRESSUM</a></li>
					</ul>
				</div>
				<div class="col-sm-9">
					<div class="privacy-content" id="agb">
							<div class="margin-bottom-20 text-center">
                                    <h1 class="margin-bottom-10">Allgemeine Geschäftsbedingungen für Kunden</h1>                
                            </div>
                              <h2 class="text-left">Präambel</h2>
                                <p class=" text-justify">Betreiber dieser Plattform ist die TNKAS, Goerdelerstr. 5 in 97084 Würzburg, E-Mail: info@tnkas.de (nachfolgend „TNKAS“). TNKAS können Restaurants standortunabhängig als digitales Online-Bestellsystem nutzen. TNKAS ist ein System, bei dem das Restaurant die vollständige Kontrolle über das Menü haben, die Oberfläche von Gerichtinformationen, Preisen und Bildern im Handumdrehen ändern. Kunden können Ihr Essen zur Abholung oder Lieferung bestellen und online mit allen gängigen digitalen Zahlungsmitteln auf der Plattform bezahlen. Restaurants können intuitiv eine Speisekarte und Restaurantinfos anlegen und die Bestellungen mit nur einem Klick verwalten. Die online Präsenz ist im Web oder auch als App verfügbar.</p>

                                <h2 class="text-left">§ 1 Geltungsbereich, Form</h2>
                                <p> (1) Diese Allgemeinen Geschäftsbedingungen (nachfolgend “AGB”) gelten auf die Beziehungen zwischen Verbraucher oder Unternehmer (nachfolgend „Kunde“) mit TNKAS. Die AGB zwischen Verbraucher oder Unternehmer und TNKAS beziehen sich auf die Nutzung der mobilen App (nachfolgend die „App“) und unserer Webseite https://TNKAS-app.de/home (nachfolgend die „Webseite“) sowie aller damit im Zusammenhang stehender Leistungen (die App sowie die im Rahmen der App und der Webseite erbrachten Leistungen, nachfolgend gemeinsam „Dienste“). Hiermit wird der Einbeziehung von eigenen Bedingungen des Kunden widersprochen, es sei denn, es ist etwas anderes vereinbart.</p>
                               <p>  (2) Durch die Aufgabe einer Bestellung schließt der Kunde einen Vertrag mit dem Restaurant über die Lieferung des vom Kunden ausgewählten Angebots. TNKAS ist nicht für das Angebot und/oder den Vertrag zwischen dem Kunden und dem Restaurant verantwortlich. Gegebenenfalls gelten die Allgemeinen Geschäftsbedingungen des Restaurants zusätzlich für das Angebot und den Vertrag.</p>
                              
                              <p>  (3) Hinweise auf die Geltung gesetzlicher Vorschriften haben nur klarstellende Bedeutung. Auch ohne eine derartige Klarstellung gelten daher die gesetzlichen Vorschriften, soweit sie in diesen AGB nicht unmittelbar abgeändert oder ausdrücklich ausgeschlossen werden.</p>
                              <h2 class="text-left">  § 2 Beschreibung des Dienstes und Kunden-Accounts</h2>
                              
                              <p> (1) TNKAS stellt eine Plattform zur Verfügung, über die der eine Bestellung bei einem Restaurant auslösen kann.</p>
                              <p>(2) Das auf der Plattform veröffentlichte Angebot wird im Namen des jeweiligen Restaurants, ausgehend von den bereitgestellten Restaurantinformationen, veröffentlicht. TNKAS überprüft nicht die Richtigkeit oder Vollständigkeit der Restaurantinformationen und ist nicht verantwortlich für die Durchführung des Vertrags.</p>
                              <p>(3) Nutzt der Kunde die Plattform nur für eine Bestellung im Restaurant, kann er auf der Website als Gast bestellen und muss sich nicht extra auf der Plattform registrieren.</p>
                              <p>(4) Erstellt der Kunde ein dauerhaftes, zur wiederholten Bestellung nutzbares Konto bei TNKAS („Kundekonto“), hat er sich mit den erforderlichen Daten (insbesondere Adress- und Kontaktdaten) zu registrieren. Der Kunde gewährleistet, dass alle von ihm übermittelten Daten zur Person der Wahrheit entsprechen. Der Kunde darf sich nicht als andere Personen oder Unternehmen ausgeben oder sonst über seine Identität täuschen. </p>
                              <p>(5) Die Adress- und Kontaktdaten des Kundens sind stets auf dem aktuellen Stand zu halten. Der Kunde ist dafür verantwortlich, dass eine Bestellung nicht aufgrund von falschen Angaben (z. B. der Lieferadresse, E-Mail oder Zahlungsdaten) nicht ausgeführt werden kann. </p>
                              <p>(6) Jeder Kunde darf lediglich ein Kundenkonto gleichzeitig unterhalten. TNKAS hat das Recht, Mehrfachanmeldungen zu löschen und Kunden, die gegen diese Bestimmung verstoßen, zu verwarnen oder zu kündigen (Virtuelles Hausrecht). </p>
                              <p>(7) Dem Kunden obliegt es, bei der Benutzung seiner Zugangsdaten größtmögliche Sorgfalt walten zu lassen und jedwede Maßnahme zu ergreifen, welche den vertraulichen, sicheren Umgang mit den Daten gewährleistet und deren Bekanntgabe an Dritte verhindert. </p>
                              <p>(8) Eine Kündigung des Kundenkontos ist jederzeit in Textform gegenüber der TNKAS möglich. Bereits entstandene Zahlungsansprüche von TNKAS sowie Lieferansprüche des Kunden bleiben von der Kündigung unberührt.</p>
                              
                               
                              
                               
                                
                              <h2 class="text-left">§ 3 Vertragsschluss zwischen Kunde und Restaurant</h2>
                                <p>(1) Der Kunde kann sein Angebot zum Vertragsschluss (Bestellung) sowohl über die Website als auch – soweit von der TNKAS zum Zeitpunkt der Bestellung angeboten – per App abgegeben.</p>
                                <p> (2) Der Vertrag zwischen dem Restaurant und dem Kunden kommt wirksam zustande, sobald der Kunde die Bestellung aufgibt und am Ende des Bestellvorgangs auf der Plattform die Schaltfläche „Zahlungspflichtig Bestellen“ anklickt.</p>
                                <p> (3) Nach Eingang der Bestellung wird TNKAS die Bestellung dem Kunden elektronisch bestätigen.</p>
                                <p> (4) Das Restaurant ist berechtigt, die Bestellung zu stornieren, wenn das Angebot nicht mehr verfügbar ist, wenn der Kunde eine falsche oder nicht funktionierende Telefonnummer oder andere Kontaktinformationen angegeben hat oder wenn ein Fall höherer Gewalt vorliegt. </p>
                                <p>(5) Der Vertrag kann vom Restaurant nur dann ausgeführt werden, wenn der Kunde bei der Bestellung korrekte und vollständige Kontakt- und Adressinformationen zur Verfügung stellt. Der Kunde ist verpflichtet, unverzüglich alle Ungenauigkeiten der Informationen (einschließlich der Zahlungsdaten) zu melden die an TNKAS oder das Restaurant übermittelt oder weitregegeben worden.</p>
                                <p>(6) Wenn der Kunde die Bestellung zur Lieferung auslöst, muss die Lieferung durch das Restaurant gewährleistet werden. TNKAS stellt keine Lieferleistung zur Verfügung. Für die einwandfreie Lieferung und die damit einwandfrei eingehaltene Lieferkette ist das Restaurant selber zuständig. TNKAS übernimmt für die Lieferung keine Haftung.</p>
                                <p> (7) Wenn der Kunde die Bestellung zur Lieferung auslöst, verpflichtet sich der Kunde an der angegebenen Lieferadresse anwesend zu sein.</p>
                                <p> (8) Wenn der Kunde die Bestellung zur Abholung auslöst, ist er verpflichtet zum ausgewählten Zeitpunkt am Abholungsort des Restaurants anwesend zu sein. Um die Bestellung abholen zu können, muss der Kunde, den im zugeschickten QR Code vorzeigen und diesen vom Restaurant abscannen lassen, damit ist sichergestellt das der Kunde nur die von Ihm bestellte Bestellung abholen kann.</p>
                                <p>(9) Bei der Zustellung der Bestellung, kann das Restaurant die Vorlage einer Alters-Identifizierung fordern, wenn die Bestellung alkoholische Produkte oder andere Produkte mit einer Altersgrenze enthält. Kann sich der Kunde nicht angemessen ausweisen oder erfüllt er nicht die Altersanforderungen, kann das Restaurant die Lieferung der entsprechenden Produkte an den Kunden verweigern. In diesem Fall können Stornokosten in Höhe des Kaufpreises (ohne USt.) für das Produkt mit Altersgrenze dem Kunden berechnet werden.</p>
                                <p>(10) Das Restaurant ist allein verantwortlich für die Abwicklung von Kundenbeschwerden hinsichtlich der Erfüllung von Vereinbarungen. </p>
                               
                                <h2 class="text-left">§ 4 Stornierung, Ablehnen von Bestellungen</h2>
                                <p> (1) Eine Stornierung der Bestellung gegenüber dem Restaurant ist für den Kunden nur dann möglich, wenn das Restaurant ausdrücklich angibt, dass eine Stornierung der Bestellung durch den Kunden möglich ist. </p>
                                <p>(2) Das Restaurant ist berechtigt, die Bestellung zu stornieren, z.B. wenn das Angebot nicht mehr verfügbar ist, wenn der Kunde eine falsche oder nicht funktionierende Telefonnummer oder andere Kontaktinformationen angegeben hat oder wenn höhere Gewalt vorliegt. TNKAS ist berechtigt, alle (künftigen) Bestellungen von einem Kunden abzulehnen, sollten entsprechende Gründe vorliegen. </p>
                                <p>(3) Wenn der  eine falsche Bestellung (z.B. indem er falsche Kontaktinformationen angibt, indem er nicht bezahlt oder nicht am Lieferungs- oder Abholungsort anwesend ist, um den Auftrag zu erhalten) aufgibt oder anderweitig seinen Verpflichtungen gemäß dem Vertrag nicht nachkommt, ist TNKAS berechtigt, zukünftige Bestellungen von diesem Kunden abzulehnen. </p>
                                <p> (4) TNKAS ist berechtigt, Bestellungen abzulehnen und Verträge im Namen des Restaurants aufzulösen, wenn es angemessene Zweifel bezüglich der Richtigkeit oder Echtheit der Bestellung oder der Kontaktinformationen gibt oder falls das Restaurant keinen Vertrag mit dem Kunden schließen möchte.</p>
                                <p> (5) Wenn der Kunde Bestellungen aufgibt, die falsch oder betrügerisch erscheinen oder sind, behält sich TNKAS Anzeige bei der Polizei zu erstatten. </p>
                               
                                
                                
                                <h2 class="text-left"> § 5 Zahlungsmodalitäten, Preise und Mindestbestellwert</h2>
                               <p> (1) Zum Zeitpunkt des Vertragsabschlusses entsprechend den Bestimmungen aus vorliegenden Allgemeinen Geschäftsbedingungen für Kunden entsteht auf Seiten des Kundens eine Leistungsverpflichtung gegenüber dem Restaurant. Der Kunde kann diese Zahlungsverpflichtung durch Nutzung einer Online-Zahlungsmethode über die Plattform erfüllen. </p>
                               <p> (2) Es werden nur die auf der Bestellplattform angezeigten Zahlungsarten akzeptiert. Die zur Verfügung stehenden Zahlungsarten können auf der Internetseite www.TNKAS-app.de eingesehen werden.</p>
                               <p>(3) Werden Drittanbieter mit der Zahlungsabwicklung beauftragt gelten deren Allgemeine Vertrags-/ und Zahlungsbedingungen jeweils in der aktuell verfügbaren Fassung.</p>
                               
                              
                               <h2 class="text-left">§ 6 Haftung</h2>
                               <p>  (1) Ansprüche des Kunden auf Schadensersatz sind ausgeschlossen. Hiervon ausgenommen sind Schadensersatzansprüche des Kunden aus der Verletzung des Lebens, des Körpers, der Gesundheit oder aus der Verletzung wesentlicher Vertragspflichten (Kardinalpflichten) sowie die Haftung für sonstige Schäden, die auf einer vorsätzlichen oder grob fahrlässigen Pflichtverletzung von TNKAS, seiner gesetzlichen Vertreter oder Erfüllungsgehilfen beruhen. Wesentliche Vertragspflichten sind solche, deren Erfüllung zur Erreichung des Ziels des Vertrags notwendig ist.</p>
                               <p>(2) Bei der Verletzung wesentlicher Vertragspflichten haftet TNKAS nur auf den vertragstypischen, vorhersehbaren Schaden, wenn dieser einfach fahrlässig verursacht wurde, es sei denn, es handelt sich um Schadensersatzansprüche des Kunden aus einer Verletzung des Lebens, des Körpers oder der Gesundheit.</p>
                               <p>   
                                (3) Für Schäden oder Störungen, die auf der Fehlerhaftigkeit oder Inkompatibilität von Soft- oder Hardware der Teilnehmer beruhen, sowie für Schäden, die auf Grund der mangelnden Verfügbarkeit oder der Funktionsweise des Internets entstanden sind, ist TNKAS nicht verantwortlich.</p>
                               <p> (4) Für die verwendeten Zutaten und Zusatzstoffe für Speisen und Getränke, die ggf. Allergien und Unverträglichkeiten auslösen können, ist TNKAS nicht haftbar. Haben Sie als Kunde eine Unverträglichkeit oder eine Allergie, raten wir Ihnen, sich telefonisch mit dem Restaurant in Verbindung zu setzen, um sich über verwendete Allergene zu informieren, bevor Sie eine Bestellung über unsere Plattform auslösen.</p>      
                               <h2 class="text-left">§ 7 Datenschutz</h2>    
                                <p>  Personenbezogene Daten, die erforderlich sind, um ein Vertragsverhältnis mit Ihnen einschließlich seiner inhaltlichen Ausgestaltung zu begründen oder zu ändern sowie personenbezogene Daten zur Bereitstellung und Erbringung unserer Leistungen verarbeiten wir selbstverständlich nur im Rahmen der geltenden gesetzlichen Bestimmungen der DSGVO. Weitere Informationen sind in unseren Datenschutzhinweisen enthalten, die Sie unter folgendem Link abrufen können: <a href="https://TNKAS-app.de/datenschutzerklärung">https://TNKAS-app.de/datenschutzerklärung</a>.</p>
                              
                                <h2 class="text-left">  § 8 Widerrufsrecht </h2>    
                              
                              <p>  (1) Verbraucher haben bei Abschluss eines Fernabsatzgeschäfts grundsätzlich ein gesetzliches Widerrufsrecht, über das TNKAS nach Maßgabe des gesetzlichen Musters nachfolgend informiert. Die Ausnahmen vom Widerrufsrecht sind in Absatz (2) geregelt. In Absatz (3) findet sich ein Muster-Widerrufsformular. </p>

                              <h2>   Widerrufsbelehrung </h2>
                              <h2 class="text-left">   Widerrufsrecht  </h2>
                              
                               
                                <p>Sie haben das Recht, binnen vierzehn Tagen ohne Angaben von Gründen den Vertrag mit dem Restaurant zu widerrufen. Die Widerrufsfrist beträgt vierzehn Tage ab dem Tag, an dem Sie oder ein von Ihnen benannter Dritter, der nicht Beförderer ist, die Waren in Besitz genommen haben bzw. hat. Um Ihr Widerrufsrecht auszuüben, müssen Sie uns (Kontaktdaten siehe oben Präambel) mittels einer eindeutigen Erklärung (z.B. ein mit der Post versandter Brief, Telefax oder E-Mail) über Ihren Entschluss, den Vertrag mit dem Restaurant zu widerrufen, informieren. Sie können dafür das beigefügte Muster-Widerrufsformular verwenden, das jedoch nicht vorgeschrieben ist. </p>
                                <p>Zur Wahrung der Widerrufsfrist reicht es aus, dass Sie die Mitteilung über die Ausübung des Widerrufsrechts vor Ablauf der Widerrufsfrist absenden.</p>
                                
                                <h2 class="text-left">Folgen des Widerrufs:</h2>
                               <p> Wenn Sie den Vertrag mit dem Restaurant widerrufen, hat das Restaurant Ihnen alle Zahlungen, die es von Ihnen erhalten hat, einschließlich der Lieferkosten (mit Ausnahme der zusätzlichen Kosten, die sich daraus ergeben, dass Sie eine andere Art der Lieferung als die von uns angebotene, günstigste Standardlieferung gewählt haben), unverzüglich und spätestens binnen vierzehn Tagen ab dem Tag zurückzuzahlen, an dem die Mitteilung über Ihren Widerruf des Vertrags bei uns eingegangen ist. Für diese Rückzahlung verwendet das Restaurant dasselbe Zahlungsmittel, das Sie bei der ursprünglichen Transaktion eingesetzt haben, es sei denn, mit Ihnen wurde ausdrücklich etwas anderes vereinbart; in keinem Fall werden Ihnen wegen dieser Rückzahlung Entgelte berechnet.</p>

                              <p> Das Restaurant kann die Rückzahlung verweigern, bis es die Waren wieder zurückerhalten hat oder bis Sie den Nachweis erbracht haben, dass Sie die Waren zurückgesandt haben, je nachdem, welches der frühere Zeitpunkt ist.</p>

                                <p>Sie tragen die unmittelbaren Kosten der Rücksendung der Waren.</p>

                                <p>Sie müssen für einen etwaigen Wertverlust der Waren nur aufkommen, wenn dieser Wertverlust auf einen zur Prüfung der Beschaffenheit, Eigenschaften und Funktionsweise der Waren nicht notwendigen Umgang mit ihnen zurückzuführen ist</p>

                              <p>  (2) Auf Fernabsatzverträge zwischen dem Kunden und dem Restaurant, die unter § 312g Abs. 2 oder Abs. 3 BGB fallen, finden die Vorschriften über das Widerrufsrecht grundsätzlich keine Anwendung soweit es sich um die Lieferung von Waren handelt, </p>

                              <p>  – die nicht vorgefertigt sind und für deren Herstellung eine individuelle Auswahl oder Bestimmung durch den Verbraucher maßgeblich ist oder die eindeutig auf die persönlichen Bedürfnisse des Verbrauchers zugeschnitten sind (§ 312g Abs. 2 Nr. 1 BGB); </p>
                              
                              <p>  – die schnell verderben können oder deren Verfallsdatum schnell überschritten würde (§ 312g Abs. 2 Nr. 2 BGB); </p>

                             <p>   – die aus Gründen des Gesundheitsschutzes oder der Hygiene nicht zur Rückgabe geeignet sind, wenn ihre Versiegelung nach der Lieferung entfernt wurde (§ 312g Abs. 2 Nr. 3 BGB);</p>
                            <p>    – wenn diese nach der Lieferung auf Grund ihrer Beschaffenheit untrennbar mit anderen Gütern vermischt wurden (§ 312g Abs. 2 Nr. 4 BGB). </p>
                               <p> (3) Über das Muster-Widerrufsformular informiert TNKAS nach der gesetzlichen Regelung wie folgt:</p>

                               <h2 class="text-left">Muster-Widerrufsformular</h2>
                                <p> (Wenn Sie den Vertrag widerrufen wollen, dann füllen Sie bitte dieses Formular aus und senden Sie es zurück.)</p>
                                
                               <p>— An [TNKAS, Goerdelerstr. 5 in 97084 Würzburg, E-Mail: info@tnkas.de]:</p>
                              <p>— Hiermit widerrufe(n) ich/wir (*) den von mir/uns (*) abgeschlossenen Vertrag
                                über den Kauf der folgenden Waren (*)/ die Erbringung der folgenden
                                Dienstleistung (*)</p>
                               <p>— Bestellt am (*)/erhalten am (*)</p>
                              <p>— Name des/der Verbraucher(s)</p>
                              <p>— Anschrift des/der Verbraucher(s)</p>
                               <p>— Unterschrift des/der Verbraucher(s) (nur bei Mitteilung auf Papier)</p>       
                                <p>— Datum</p>
                               <p>(*) Unzutreffendes streichen</p>
                                
                                <h2 class="text-left">§ 9 Alternative Streitbeilegung</h2>
                               <p> Die EU-Kommission hat eine Internetplattform zur Online-Beilegung von Streitigkeiten geschaffen. Die Plattform dient als Anlaufstelle zur außergerichtlichen Beilegung von Streitigkeiten betreffend vertragliche Verpflichtungen, die aus Online-Kaufverträgen erwachsen. Nähere Informationen sind unter dem folgenden Link verfügbar: <a href="http://ec.europa.eu/consumers/odr">http://ec.europa.eu/consumers/odr</a> . Zur Teilnahme an einem Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle sind wir weder bereit noch verpflichtet.</p>
                                
                                <h2 class="text-left">§ 10 Anwendbares Recht und Gerichtsstand</h2>
                                <p>(1) Es gilt das Recht der Bundesrepublik Deutschland unter Ausschluss der kollisionsrechtlichen Regelungen des Internationalen Privatrechts sowie unter Ausschluss des Kaufrechts der Vereinten Nationen. Sind Sie eine natürliche Person, die das Rechtsgeschäft mit uns zu Zwecken abschließt, die überwiegend weder einer gewerblichen noch einer selbständigen beruflichen Tätigkeit zugeordnet werden können, gilt diese Rechtswahl nur insoweit, als Ihnen hierdurch nicht der gewährte Schutz durch zwingende Bestimmungen des Staates, in dem Sie Ihren gewöhnlichen Aufenthalt haben, entzogen wird.</p>
                                <p>   (2) Haben Sie keinen allgemeinen Gerichtsstand in Deutschland oder in einem anderen EU-Mitgliedsstaat, oder sind Sie Kaufmann oder eine juristische Person des öffentlichen Rechts oder haben Sie Ihren festen Wohnsitz nach Einbeziehung dieser AGB ins Ausland verlegt oder ist Ihr Wohnsitz oder gewöhnlicher Aufenthaltsort im Zeitpunkt der Klageerhebung nicht bekannt, ist ausschließlicher Gerichtsstand für sämtliche Streitigkeiten aus diesem Vertrag der Sitz von TNKAS.</p>                                        
                            
					</div><!--END AGB-->

					<div class="privacy-content" id="datenschutzerklarung">
								
    <div class="row margin-bottom-20 justify-content-center">
        <h1 class="margin-bottom-10">Datenschutzerklärung</h1>   
    </div>
    <h2 class="text-left">Vorwort</h2>
    <p>Wir, TNKAS, Goerdelerstr. 5 in 97084 Würzburg (nachfolgend: "das Unternehmen", "wir" oder "uns") nehmen den Schutz Ihrer personenbezogenen Daten ernst und möchten Sie an dieser Stelle über den Datenschutz in unserem Unternehmen informieren.</p>
<p>Uns sind im Rahmen unserer datenschutzrechtlichen Verantwortlichkeit durch das Inkrafttreten der EU-Datenschutz-Grundverordnung (Verordnung (EU) 2016/679; nachfolgend: "DSGVO") zusätzliche Pflichten auferlegt worden, um den Schutz personenbezogener Daten der von einer Verarbeitung betroffenen Person (wir sprechen Sie als betroffene Person nachfolgend auch mit "Kunde", "Nutzer", "Sie", "Ihnen" oder "Betroffener" an) sicherzustellen.</p>


<p>Soweit wir entweder alleine oder gemeinsam mit anderen über die Zwecke und Mittel der Datenverarbeitung entscheiden, umfasst dies vor allem die Pflicht, Sie transparent über Art, Umfang, Zweck, Dauer und Rechtsgrundlage der Verarbeitung zu informieren (vgl. Art. 13 und 14 DSGVO). Mit dieser Erklärung (nachfolgend: "Datenschutzhinweise") informieren wir Sie darüber, in welcher Weise Ihre personenbezogenen Daten von uns verarbeitet werden.</p>

<p>Unsere Datenschutzhinweise sind modular aufgebaut. Sie bestehen aus einem allgemeinen Teil für jegliche Verarbeitung personenbezogener Daten und Verarbeitungssituationen, die bei jedem Aufruf einer Webseite zum Tragen kommen (Teil A. Allgemeines) und einem besonderen Teil, dessen Inhalt sich jeweils nur auf die dort angegebene Verarbeitungssituation mit Bezeichnung des jeweiligen Angebots oder Produkts bezieht, insbesondere den hier näher ausgestalteten Besuch von Webseiten (Teil B. Besuch von Webseiten). Teil B ist relevant, wenn Sie unser deutsches Internetangebot inklusive der Auftritte in den sozialen Medien nutzen. </p>

<h1 class="text-left">A. Allgemeines</h1>
<h2 class="text-left">(1) Begriffsbestimmungen</h2>

<p>Nach dem Vorbild des Art. 4 DSGVO liegen dieser Datenschutzhinweise folgende Begriffsbestimmungen zugrunde:</p>
<p>- "Personenbezogene Daten" (Art. 4 Nr. 1 DSGVO) sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person ("Betroffener") beziehen. Identifizierbar ist eine Person, wenn sie direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, einer Kennnummer, einer Online-Kennung, Standortdaten oder mithilfe von Informationen zu ihren physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identitätsmerkmalen identifiziert werden kann. Die Identifizierbarkeit kann auch mittels einer Verknüpfung von derartigen Informationen oder anderem Zusatzwissen gegeben sein. Auf das Zustandekommen, die Form oder die Verkörperung der Informationen kommt es nicht an (auch Fotos, Video- oder Tonaufnahmen können personenbezogene Daten enthalten).</p>
<p>- "Verarbeiten" (Art. 4 Nr. 2 DSGVO) ist jeder Vorgang, bei dem mit personenbezogenen Daten umgegangen wird, gleich ob mit oder ohne Hilfe automatisierter (d.h. technikgestützter) Verfahren. Dies umfasst insbesondere das Erheben (d.h. die Beschaffung), das Erfassen, die Organisation, das Ordnen, die Speicherung, die Anpassung oder Veränderung, das Auslesen, das Abfragen, die Verwendung, die Offenlegung durch Übermittlung, die Verbreitung oder sonstige Bereitstellung, den Abgleich, die Verknüpfung, die Einschränkung, das Löschen oder die Vernichtung von personenbezogenen Daten sowie die Änderung einer Ziel- oder Zweckbestimmung, die einer Datenverarbeitung ursprünglich zugrunde gelegt wurde.</p>

<p>- "Verantwortlicher" (Art. 4 Nr. 7 DSGVO) ist die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet.</p>
<p>"Dritter" (Art. 4 Nr. 10 DSGVO) ist jede natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle außer dem Betroffenen, dem Verantwortlichen, dem Auftragsverarbeiter und den Personen, die unter der unmittelbaren Verantwortung des Verantwortlichen oder Auftragsverarbeiters befugt sind, die personenbezogenen Daten zu verarbeiten; dazu gehören auch andere konzernangehörige juristische Personen.</p>
<p>"Auftragsverarbeiter" (Art. 4 Nr. 8 DSGVO) ist eine natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die personenbezogene Daten im Auftrag des Verantwortlichen, insbesondere gemäß dessen Weisungen, verarbeitet (z.&thinsp;B. IT-Dienstleister). Im datenschutzrechtlichen Sinne ist ein Auftragsverarbeiter insbesondere kein Dritter.</p>
<p>"Einwilligung" (Art. 4 Nr. 11 DSGVO) der betroffenen Person bezeichnet jede freiwillig für den bestimmten Fall, in informierter </p>
<p>Weise und unmissverständlich abgegebene Willensbekundung in Form einer Erklärung oder einer sonstigen eindeutigen bestätigenden Handlung, mit der die betroffene Person zu verstehen gibt, dass sie mit der Verarbeitung der sie betreffenden personenbezogenen Daten einverstanden ist.</p>
<h2 class="text-left">(2) Name und Anschrift des für die Verarbeitung Verantwortlichen</h2>
<p>Die für die Verarbeitung Ihrer personenbezogenen Daten verantwortliche Stelle im Sinne des Art. 4 Nr. 7 DSGVO sind wir:</p>
<p>TNKAS</p>
<p>Goerdelerstr. 5</p>
<p>97084 Würzburg</p>
<p>+49 931 6605 7362</p>
<p></p>
<p>info@d-gastro24.de</p>
<p>Weitere Angaben zu unserem Unternehmen entnehmen Sie bitte den  Impressumsangaben auf unserer Internetseite <a href="https://d-gastro24.de/impressum-kunden">Impressum</a>.</p>
<h2 class="text-left">(3) Rechtsgrundlagen der Datenverarbeitung</h2>
<p>Von Gesetzes wegen ist im Grundsatz jede Verarbeitung personenbezogener Daten verboten und nur dann erlaubt, wenn die Datenverarbeitung unter einen der folgenden Rechtfertigungstatbestände fällt:</p>
<p>- Art. 6 Abs. 1 S. 1 lit. a DSGVO ("Einwilligung"): Wenn der Betroffene freiwillig, in informierter Weise und unmissverständlich durch eine Erklärung oder eine sonstige eindeutige bestätigende Handlung zu verstehen gegeben hat, dass er mit der Verarbeitung der ihn betreffenden personenbezogenen Daten für einen oder mehrere bestimmte 
Zwecke einverstanden ist;</p>
<p>- Art. 6 Abs. 1 S. 1 lit. b DSGVO: Wenn die Verarbeitung zur Erfüllung eines Vertrags, dessen Vertragspartei der Betroffene ist, oder zur Durchführung vorvertraglicher Maßnahmen erforderlich ist, die auf die Anfrage des Betroffenen erfolgen;</p>

<p>- Art. 6 Abs. 1 S. 1 lit. c DSGVO: Wenn die Verarbeitung zur Erfüllung einer rechtlichen Verpflichtung erforderlich ist, der der Verantwortliche unterliegt (z.&thinsp;B. eine gesetzliche Aufbewahrungspflicht);</p>
<p>Art. 6 Abs. 1 S. 1 lit. d DSGVO: Wenn die Verarbeitung erforderlich ist, um lebenswichtige Interessen des Betroffenen oder einer anderen natürlichen Person zu schützen;</p>
<p>Art. 6 Abs. 1 S. 1 lit. e DSGVO: Wenn die Verarbeitung für die </p>
<p>Wahrnehmung einer Aufgabe erforderlich ist, die im öffentlichen Interesse liegt oder in Ausübung öffentlicher Gewalt erfolgt, die dem Verantwortlichen übertragen wurde oder</p>
<p>Art. 6 Abs. 1 S. 1 lit. f DSGVO ("Berechtigte Interessen"): Wenn die Verarbeitung zur Wahrung berechtigter (insbesondere rechtlicher oder wirtschaftlicher) Interessen des </p>
<p>Verantwortlichen oder eines Dritten erforderlich ist, sofern nicht die gegenläufigen Interessen oder Rechte des Betroffenen überwiegen (insbesondere dann, wenn es sich dabei um einen Minderjährigen handelt). </p>
<p>Für die von uns vorgenommenen Verarbeitungsvorgänge geben wir im Folgenden jeweils die anwendbare Rechtsgrundlage an. Eine Verarbeitung kann auch auf mehreren Rechtsgrundlagen beruhen.</p>
<h2 class="text-left">(4) Datenlöschung und Speicherdauer</h2>
<p>Für die von uns vorgenommenen Verarbeitungsvorgänge geben wir im Folgenden jeweils an, wie lange die Daten bei uns gespeichert und wann sie gelöscht oder gesperrt werden. Soweit nachfolgend keine ausdrückliche Speicherdauer angegeben wird, werden Ihre personenbezogenen Daten gelöscht oder gesperrt, sobald der Zweck oder die Rechtsgrundlage für die Speicherung entfällt. Eine Speicherung Ihrer Daten erfolgt grundsätzlich nur auf unseren Servern in Deutschland, vorbehaltlich einer ggf. erfolgenden Weitergabe nach den Regelungen in A.(6) und A.(7).Eine Speicherung kann jedoch über die angegebene Zeit hinaus im Falle einer (drohenden) Rechtsstreitigkeit mit Ihnen oder eines sonstigen rechtlichen Verfahrens erfolgen oder wenn die Speicherung durch gesetzliche Vorschriften, denen wir als Verantwortlicher unterliegen (zB § 257 HGB, § 147 AO), vorgesehen ist. Wenn die durch die gesetzlichen Vorschriften vorgeschriebene Speicherfrist abläuft, erfolgt eine Sperrung oder Löschung der personenbezogenen Daten, es sei denn, dass eine weitere Speicherung durch uns erforderlich ist und dafür eine Rechtsgrundlage besteht. </p>

<h2 class="text-left">(5) Datensicherheit</h2>
<p>Wir bedienen uns geeigneter technischer und organisatorischer Sicherheitsmaßnahmen, um Ihre Daten gegen zufällige oder vorsätzliche Manipulationen, teilweisen oder vollständigen Verlust, Zerstörung oder gegen den unbefugten Zugriff Dritter zu schützen (z.B. TSL-Verschlüsselung für unsere Webseite) unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Natur, des Umfangs, des Kontextes und des Zwecks der Verarbeitung sowie der bestehenden Risiken einer Datenpanne (inklusive von deren Wahrscheinlichkeit und Auswirkungen) für den Betroffenen. Unsere Sicherheitsmaßnahmen werden entsprechend der technologischen Entwicklung fortlaufend verbessert. Nähere Informationen hierzu erteilen wir Ihnen auf Anfrage gerne.</p>
<h2 class="text-left">(6) Zusammenarbeit mit Auftragsverarbeitern</h2>
<p>Wenn wir zur Abwicklung unseres Geschäftsverkehrs externe Dienstleister (z.&thinsp;B. für die Bereiche IT, Logistik, Telekommunikation, Vertrieb und Marketing) einsetzen, dann werden diese nur nach unserer Weisung tätig und werden i.S.v. Art. 28 DSGVO vertraglich dazu verpflichtet, die datenschutzrechtlichen Bestimmungen einzuhalten.</p>
<h2 class="text-left">(7) Voraussetzungen der Weitergabe von personenbezogenen Daten in Drittländer</h2>
<p>Im Rahmen unserer Geschäftsbeziehungen können Ihre personenbezogenen Daten an Drittgesellschaften weitergegeben oder offengelegt werden. Diese können sich auch außerhalb des Europäischen Wirtschaftsraums (EWR), also in Drittländern, befinden. Eine derartige Verarbeitung erfolgt ausschließlich zur Erfüllung der vertraglichen und geschäftlichen Verpflichtungen und zur Pflege Ihrer Geschäftsbeziehung zu uns. Über die jeweiligen Einzelheiten der Weitergabe unterrichten wir Sie nachfolgend an den dafür relevanten Stellen. Einigen Drittländern bescheinigt die Europäische Kommission durch sog. Angemessenheitsbeschlüsse einen Datenschutz, der dem EWR-Standard vergleichbar ist (eine Liste dieser Länder sowie eine Kopie der Angemessenheitsbeschlüsse erhalten Sie hier: <a href="http://ec.europa.eu/justice/data-protection/internationaltransfers/adequacy/index_en.html">http://ec.europa.eu/justice/data-protection/internationaltransfers/adequacy/index_en.html</a>). In anderen Drittländern, in die ggf. personenbezogene Daten übertragen werden, herrscht aber unter Umständen wegen fehlender gesetzlicher Bestimmungen kein durchgängig hohes Datenschutzniveau. Soweit dies der Fall ist, achten wir darauf, dass der Datenschutz ausreichend gewährleistet ist. Möglich ist dies über bindende Unternehmensvorschriften, Standard-Vertragsklauseln der Europäischen Kommission zum Schutz personenbezogener Daten, Zertifikate oder anerkannte Verhaltenskodizes.</p> 
<h2 class="text-left">(8) Keine automatisiere Entscheidungsfindung (einschließlich Profiling)</h2>
<p>Wir haben nicht die Absicht, von Ihnen erhobene personenbezogene Daten für ein Verfahren zur automatisierten Entscheidungsfindung (einschließlich Profiling) zu verwenden.</p>
<h2 class="text-left">(9) Keine Verpflichtung zur Bereitstellung personenbezogener Daten</h2>
<p>Wir machen den Abschluss von Verträgen mit uns nicht davon abhängig, dass Sie uns zuvor personenbezogene Daten bereitstellen. Für Sie als Kunde besteht grundsätzlich auch keine gesetzliche oder vertragliche Verpflichtung, uns Ihre personenbezogenen Daten zur Verfügung zu stellen; es kann jedoch sein, dass wir bestimmte Angebote nur eingeschränkt oder gar nicht erbringen können, wenn Sie die dafür erforderlichen Daten nicht bereitstellen. Sofern dies im Rahmen der nachfolgend vorgestellten, von uns angebotenen Produkte ausnahmsweise der Fall sein sollte, werden Sie gesondert darauf hingewiesen.</p>
<h2 class="text-left">(10) Gesetzliche Verpflichtung zur Übermittlung bestimmter Daten</h2>
<p>Wir können unter Umständen einer besonderen gesetzlichen oder rechtlichen Verpflichtung unterliegen, die rechtmäßig verarbeiteten personenbezogenen Daten für Dritte, insbesondere öffentlichen Stellen, bereitzustellen (Art. 6 Abs. 1 S. 1 lit. c DSGVO).</p>
<h2 class="text-left">(11) Ihre Rechte</h2>
<p>Ihre Rechte als Betroffener bezüglich Ihrer verarbeiteten personenbezogenen Daten können Sie uns gegenüber unter den eingangs unter A.(2) angegebenen Kontaktdaten jederzeit geltend machen. Sie haben als </p>
<p>Betroffener das Recht:</p>
<p>- gemäß Art. 15 DSGVO Auskunft über Ihre von uns verarbeiteten Daten zu verlangen. Insbesondere können Sie Auskunft über die Verarbeitungszwecke, die Kategorie der Daten, die Kategorien von Empfängern, gegenüber denen Ihre Daten offengelegt wurden oder werden, die geplante Speicherdauer, das Bestehen eines Rechts auf Berichtigung, Löschung, Einschränkung der Verarbeitung oder Widerspruch, das Bestehen eines Beschwerderechts, die Herkunft ihrer Daten, sofern diese nicht bei uns erhoben wurden, sowie über das Bestehen einer automatisierten Entscheidungsfindung einschließlich Profiling und ggf. aussagekräftigen Informationen zu deren Einzelheiten verlangen;</p>
<p>gemäß Art. 16 DSGVO unverzüglich die Berichtigung unrichtiger oder die Vervollständigung Ihrer bei uns gespeicherten Daten zu verlangen;</p>
<p>- gemäß Art. 17 DSGVO die Löschung Ihrer bei uns gespeicherten Daten zu verlangen, soweit nicht die Verarbeitung zur Ausübung des Rechts auf freie Meinungsäußerung und Information, zur Erfüllung einer rechtlichen Verpflichtung, aus Gründen des öffentlichen Interesses oder zur Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen erforderlich ist;</p>
<p>- gemäß Art. 18 DSGVO die Einschränkung der Verarbeitung Ihrer Daten zu verlangen, soweit die Richtigkeit der Daten von Ihnen bestritten wird oder die Verarbeitung unrechtmäßig ist;</p>
<p>- gemäß Art. 20 DSGVO Ihre Daten, die Sie uns bereitgestellt haben, in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten oder die Übermittlung an einen anderen Verantwortlichen zu verlangen ("Datenübertragbarkeit");</p>
<p>- gemäß Art. 21 DSGVO Widerspruch gegen die Verarbeitung einzulegen, sofern die Verarbeitung aufgrund von Art. 6 Abs. 1 S. 1 lit. e oder lit. f DSGVO erfolgt. Dies ist insbesondere der Fall, wenn die Verarbeitung nicht zur Erfüllung eines Vertrags mit Ihnen erforderlich ist. Sofern es sich nicht um einen Widerspruch gegen Direktwerbung handelt, bitten wir bei Ausübung eines solchen Widerspruchs um die Darlegung der Gründe, weshalb wir Ihre Daten nicht wie von uns durchgeführt verarbeiten sollen. Im Falle Ihres begründeten Widerspruchs prüfen wir die Sachlage und werden entweder die Datenverarbeitung einstellen bzw. anpassen oder Ihnen unsere zwingenden schutzwürdigen Gründe aufzeigen, aufgrund derer wir die Verarbeitung fortführen;</p>
<p>- gemäß Art. 7 Abs. 3 DSGVO Ihre einmal (auch vor der Geltung der DSGVO, dh vor dem 25.5.2018) erteilte Einwilligung – also Ihr freiwilliger, in informierter Weise und unmissverständlich durch eine Erklärung oder eine sonstige eindeutige bestätigende Handlung verständlich gemachter Willen, dass Sie mit der Verarbeitung der betreffenden personenbezogenen Daten für einen oder mehrere bestimmte Zwecke einverstanden sind – jederzeit uns gegenüber zu widerrufen, falls Sie eine solche erteilt haben. Dies hat zur Folge, dass wir die Datenverarbeitung, die auf dieser Einwilligung beruhte, für die Zukunft nicht mehr fortführen dürfen und</p>
<p>gemäß Art. 77 DSGVO sich bei einer Datenschutz-Aufsichtsbehörde über die Verarbeitung Ihrer personenbezogenen Daten in unserem Unternehmen zu beschweren.</p>
<h2 class="text-left">(12) Änderungen der Datenschutzhinweise</h2>
<p>Im Rahmen der Fortentwicklung des Datenschutzrechts sowie technologischer oder organisatorischer Veränderungen werden unsere Datenschutzhinweise regelmäßig auf Anpassungs- oder Ergänzungsbedarf hin überprüft. </p>

<h1 class="text-left">B. Besuch von Webseiten</h1>
<h2 class="text-left">(1) Erläuterung der Funktion</h2>
<p>Informationen zu unseren Unternehmen und den von uns angebotenen Leistungen erhalten Sie insbesondere unter <a href="https://d-gastro24.de/">https://d-gastro24.de/</a> samt den dazugehörigen Unterseiten (nachfolgend gemeinsam: "Webseiten"). Bei einem Besuch unserer Webseiten können personenbezogene Daten von Ihnen verarbeitet werden.</p>
<h2 class="text-left">(2) Verarbeitete personenbezogene Daten</h2>
<p>Bei der informatorischen Nutzung der Webseiten werden die folgenden Kategorien personenbezogener Daten von uns erhoben, gespeichert und weiterverarbeitet:</p>
<p>"Protokolldaten": Wenn Sie unsere Webseiten besuchen, wird auf unserem Webserver temporär und anonymisiert ein sogenannter Protokolldatensatz (sog. Server-Logfiles) gespeichert. Dieser besteht aus:</p>
<p>- der Seite, von der aus die Seite angefordert wurde (sog. Referrer-URL)</p>
<p>- dem Name und URL der angeforderten Seite</p>
<p>- dem Datum und der Uhrzeit des Aufrufs</p>
<p>- der Beschreibung des Typs, Sprache und Version des verwendeten 
Webbrowsers</p>
<p>- der IP-Adresse des anfragenden Rechners, die so verkürzt wird, dass ein Personenbezug nicht mehr herstellbar ist</p>
<p>- der übertragenen Datenmenge</p>
<p>- dem Betriebssystem</p>
<p>- der Meldung, ob der Aufruf erfolgreich war (Zugriffsstatus/Http-Statuscode)</p>
<p>- der GMT-Zeitzonendifferenz</p>

<p>"Kontaktformulardaten": Bei Nutzung von Kontaktformularen werden die dadurch übermittelten Daten verarbeitet (z.&thinsp;B. Geschlecht, Name und Vorname, Anschrift, Firma, E-Mail-Adresse und der Zeitpunkt der Übermittlung). Neben der rein informatorischen Nutzung unserer Webseite bieten wir das Abonnement unseres Newsletters an, mit dem wir Sie über aktuelle Entwicklungen im Wirtschaftsrecht und Veranstaltungen informieren. Wenn Sie sich für unseren Newsletter anmelden, werden die folgenden "Newsletterdaten" von uns erhoben, gespeichert und weiterverarbeitet:</p>
<p>- die Seite, von der aus die Seite angefordert wurde (sog. Referrer-URL)</p>
<p>- das Datum und die Uhrzeit des Aufrufs</p>
<p>- die Beschreibung des Typs des verwendeten Webbrowsers</p>
<p>- die IP-Adresse des anfragenden Rechners, die so verkürzt wird, dass ein Personenbezug nicht mehr herstellbar ist</p>
<p>- die E-Mail-Adresse</p>
<p>- das Datum und die Uhrzeit der Anmeldung und Bestätigung</p>
<p>Wir weisen Sie darauf hin, dass wir bei Versand des Newsletters Ihr Nutzerverhalten auswerten. Für diese Auswertung beinhalten die versendeten E-Mails sogenannte Web-Beacons bzw. Tracking-Pixel, die Ein-PixelBilddateien darstellen, die auf unserer Website gespeichert sind. Für die Auswertungen verknüpfen wir die vorstehend genannten Daten und die Web-Beacons mit Ihrer E-Mail-Adresse und einer individuellen ID. Auch im Newsletter enthaltene Links enthalten diese ID. Die Daten werden ausschließlich pseudonymisiert erhoben, dh. die IDs werden also nicht mit Ihren weiteren persönlichen Daten verknüpft, eine direkte Personenbeziehbarkeit wird ausgeschlossen.</p>
<h2 class="text-left">(3) Zweck und Rechtsgrundlage der Datenverarbeitung</h2>
<p>Wir verarbeiten die vorstehend näher bezeichneten personenbezogenen Daten in Einklang mit den Vorschriften der DSGVO, den weiteren einschlägigen Datenschutzvorschriften und nur im erforderlichen Umfang. Soweit die Verarbeitung der personenbezogenen Daten auf Art. 6 Abs. 1 S. 1 lit. f DSGVO beruht, stellen die genannten Zwecke zugleich unsere berechtigten Interessen dar. Die Verarbeitung der Protokolldaten dient statistischen Zwecken und der Verbesserung der Qualität unserer Webseite, insbesondere der Stabilität und der Sicherheit der Verbindung (Rechtsgrundlage ist Art. 6 Abs. 1 S. 1 lit. f DSGVO). Die Verarbeitung von Kontaktformulardaten erfolgt zur Bearbeitung von Kundenanfragen (Rechtsgrundlage ist Art. 6 Abs. 1 S. 1 lit. b oder lit. f DSGVO). Die Verarbeitung der Newsletterdaten erfolgt zum Zweck der Zusendung des Newsletters. Im Rahmen der Anmeldung zu unserem Newsletter willigen Sie in die Verarbeitung Ihrer personenbezogenen Daten ein (Rechtsgrundlage ist Art. 6 Abs. 1 lit. a DSGVO). Für die Anmeldung zu unserem Newsletter verwenden wir das sog. Double-Opt-In-Verfahren. Das heißt, dass wir Ihnen nach Ihrer Anmeldung eine E-Mail an die angegebene E-Mail-Adresse senden, in welcher wir Sie um Bestätigung bitten, dass Sie den Versand des Newsletters wünschen. Zweck dieses Verfahrens ist, Ihre Anmeldung nachweisen und ggf. einen möglichen Missbrauch Ihrer persönlichen Daten aufklären zu können. Ihre Einwilligung in die Übersendung des Newsletters können Sie jederzeit widerrufen und den Newsletter abbestellen. Den Widerruf können Sie durch Klick auf den in jeder Newsletter-E-Mail bereitgestellten Link, per E-Mail an [E-Mailadresse des Unternehmens] oder durch eine Nachricht an die im Impressum angegebenen Kontaktdaten erklären.</p>
<h2 class="text-left">(4) Dauer der Datenverarbeitung</h2>
<p>Ihre Daten werden nur so lange verarbeitet, wie dies für die Erreichung der oben genannten Verarbeitungszwecke erforderlich ist; hierfür gelten die im Rahmen der Verarbeitungszwecke angegebenen Rechtsgrundlagen entsprechend. Hinsichtlich der Nutzung und der Speicherdauer von Cookies beachten Sie bitte Punkt A.(5) sowie in den Cookie-Einstellungen.</p>
<p>Von uns eingesetzte Dritte werden Ihre Daten auf deren System so lange speichern, wie es im Zusammenhang mit der Erbringung der Leistungen für uns entsprechend dem jeweiligen Auftrag erforderlich ist. Näheres zur Speicherdauer finden Sie im Übrigen unter A.(5) und sowie in den Cookie-Einstellungen.</p>
<h2 class="text-left">(5) Übermittlung personenbezogener Daten an Dritte; Rechtfertigungsgrundlage</h2>
<p>Folgende Kategorien von Empfängern, bei denen es sich im Regelfall um Auftragsverarbeiter handelt (siehe dazu A.(7)), erhalten ggf. Zugriff auf Ihre personenbezogenen Daten:</p>
<p>- Dienstleister für den Betrieb unserer Webseite und die Verarbeitung der durch die Systeme gespeicherten oder übermittelten Daten (zB für Rechenzentrumsleistungen, Zahlungsabwicklungen, IT-Sicherheit). Rechtsgrundlage für die Weitergabe ist dann Art. 6 Abs. 1 S. 1 lit. b oder lit. f DSGVO, soweit es sich nicht um Auftragsverarbeiter handelt;</p>
<p>- Staatliche Stellen/Behörden, soweit dies zur Erfüllung einer gesetzlichen Verpflichtung erforderlich ist. Rechtsgrundlage für die Weitergabe ist dann Art. 6 Abs. 1 S. 1 lit. c DSGVO;</p>
<p>- Zur Durchführung unseres Geschäftsbetriebs eingesetzte Personen (zB Auditoren, Banken, Versicherungen, Rechtsberater, Aufsichtsbehörden, Beteiligte bei Unternehmenskäufen oder der Gründung von Gemeinschaftsunternehmen). Rechtsgrundlage für die Weitergabe ist dann Art. 6 Abs. 1 S. 1 lit. b oder lit. f DSGVO.</p>
<p>Zu den Gewährleistungen eines angemessenen Datenschutzniveaus bei einer Weitergabe der Daten in Drittländer siehe A.(8). Darüber hinaus geben wir Ihre personenbezogenen Daten nur an Dritte weiter, wenn Sie nach Art. 6 Abs. 1 S. 1 lit. a DSGVO eine ausdrückliche Einwilligung dazu erteilt haben.</p>
<h2 class="text-left">(6) Einsatz von Cookies, Plugins und sonstige Dienste auf unserer Webseite</h2>
<h3 class="text-left">a) Cookies</h3>
<p>Auf unseren Webseiten nutzen wir Cookies. Bei Cookies handelt es sich um kleine Textdateien, die auf Ihrer Festplatte dem von Ihnen verwendeten Browser durch eine charakteristische Zeichenfolge zugeordnet und gespeichert werden und durch welche der Stelle, die das Cookie setzt, bestimmte Informationen zufließen. Cookies können keine Programme ausführen oder Viren auf Ihren Computer übertragen und daher keine Schäden anrichten. Sie dienen dazu, das Internetangebot insgesamt nutzerfreundlicher und effektiver, also für Sie angenehmer zu machen. Cookies können Daten enthalten, die eine Wiedererkennung des genutzten Geräts möglich machen. Teilweise enthalten Cookies aber auch lediglich Informationen zu bestimmten Einstellungen, die nicht personenbeziehbar sind. Cookies können einen Nutzer aber nicht direkt identifizieren. Man unterscheidet zwischen Session-Cookies, die wieder gelöscht werden, sobald Sie ihren Browser schließen und permanenten Cookies, die über die einzelne Sitzung hinaus gespeichert werden. Hinsichtlich ihrer Funktion unterscheidet man bei Cookies wiederum zwischen:</p> 
<p>- Technical Cookies: Diese sind zwingend erforderlich, um sich auf der Webseite zu bewegen, grundlegende Funktionen zu nutzen und die Sicherheit der Webseite zu gewährleisten; sie sammeln weder Informationen über Sie zu Marketingzwecken noch speichern sie, welche Webseiten Sie besucht haben;</p>
<p>- Performance Cookies: Diese sammeln Informationen darüber, wie Sie unsere Webseite nutzen, welche Seiten Sie besuchen und z.&thinsp;B. ob Fehler bei der Webseitennutzung auftreten; sie sammeln keine Informationen, die Sie identifizieren könnten – alle gesammelten Informationen sind anonym und werden nur verwendet, um unsere Webseite zu verbessern und herauszufinden, was unsere Nutzer interessiert;</p>
<p>- Advertising Cookies, Targeting Cookies: Diese dienen dazu, dem Webseitennutzer bedarfsgerechte Werbung auf der Webseite oder Angebote von Dritten anzubieten und die Effektivität dieser Angebote zu messen; Advertising und Targeting Cookies werden maximal 13 Monate lang gespeichert;</p>
<p>–	Sharing Cookies: Diese dienen dazu, die Interaktivität unserer Webseite mit anderen Diensten (z.&thinsp;B. sozialen Netzwerken) zu verbessern; Sharing Cookies werden maximal 13 Monate lang gespeichert.</p>
<p>Jeder Einsatz von Cookies, der nicht zwingend technisch erforderlich ist, stellt eine Datenverarbeitung dar, die nur mit einer ausdrücklichen und aktiven Einwilligung Ihrerseits gem. Art. 6 Abs. 1 S. 1 lit. a DSGVO erlaubt ist. Dies gilt insbesondere für die Verwendung von Advertising, Targeting oder Sharing Cookies.8Darüber hinaus geben wir Ihre durch Cookies verarbeiteten personenbezogenen Daten nur an Dritte weiter, wenn Sie nach Art. 6 Abs. 1 S. 1 lit. a DSGVO eine ausdrückliche Einwilligung dazu erteilt haben.</p>
<h3 class="text-left">b) Cookie-Einstellungen </h3>
<p>Weitere Informationen darüber, welche Cookies wir verwenden und wie Sie Ihre Cookie-Einstellungen verwalten und bestimmte Arten von Tracking deaktivieren können, finden Sie in unseren Cookie-Einstellungen.</p>
    
					</div><!--ta protection-->
					<div class="privacy-content" id="impressum">
						

					<div class="row margin-bottom-20 justify-content-center">
                                <h1 class="margin-bottom-10">Impressum</h1>
                            </div>

                            <p> Unser Impressum gilt für die Seite <a href="https://d-gastro24.de/">https://d-gastro24.de/</a>.</p>

                            <h3 class="text-left">Angaben gemäß § 5 TMG:</h3>
                            <p>TNKAS</p>
                            <p>Goerdelerstr. 5</p>
                            <p>97084 Würzburg</p>
                            <p>Deutschland</p>
                            <br>
                            <h3 class="text-left">Umsatzsteuer-Identifikationsnummer gemäß §27 a Umsatzsteuergesetz:
                            </h3>
                            <p>USt-ID: <b>DE</b></p>
                            <br>
                            <h3 class="text-left">Inhaber</h3>
                            <p></p>
                            <br>
                            <h3 class="text-left">Kontakt</h3>
                            <p>Telefon: <strong>+49 931 6605 7362</strong></p>
                            <p>Telefax: </p>
                            <p>E-Mail: <strong>info@d-gastro24.de</strong></p>
                            <br>
                            <h3 class="text-left">Redaktionell Verantwortlicher</h3>
                            <p></p>
                            <br>
                            <h3 class="text-left">EU-Streitschlichtung</h3>
                            <p>Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:
                            </p>
                            <p><a href="https://ec.europa.eu/consumers/odr">https://ec.europa.eu/consumers/odr.</a></p>
                            <p>Verbraucherstreitbeilegung/Universalschlichtungsstelle</p>
                            <p>Wir sind nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer
                                Verbraucherschlichtungsstelle teilzunehmen.
                            </p>
                            <h3 class="text-left">Haftung</h3>
                            <p>Wir sind für die Inhalte unserer Internetseiten nach den Maßgaben der allgemeinen
                                Gesetzen, insbesondere nach § 7 Abs. 1 des Telemediengesetzes, verantwortlich. Alle
                                Inhalte werden mit der gebotenen Sorgfalt und nach bestem Wissen erstellt. Soweit wir
                                auf unseren Internetseiten mittels Hyperlink auf Internetseiten Dritter verweisen,
                                können wir keine Gewähr für die fortwährende Aktualität, Richtigkeit und Vollständigkeit
                                der verlinkten Inhalte übernehmen, da diese Inhalte außerhalb unseres
                                Verantwortungsbereichs liegen und wir auf die zukünftige Gestaltung keinen Einfluss
                                haben. Sollten aus Ihrer Sicht Inhalte gegen geltendes Recht verstoßen oder unangemessen
                                sein, teilen Sie uns dies bitte mit. Die rechtlichen Hinweise auf dieser Seite sowie
                                alle Fragen und Streitigkeiten im Zusammenhang mit der Gestaltung dieser Internetseite
                                unterliegen dem Recht der Bundesrepublik Deutschland.</p>

                            <h3 class="text-left">Datenschutz</h3>

                            <p>Unsere Datenschutzhinweise finden Sie unter <a href="https://d-gastro24.de/data-protection-kunden">https://d-gastro24.de/data-protection-kunden</a></p>

                            <h3 class="text-left">Urheberrechtshinweis</h3>

                            <p>Die auf unserer Internetseite vorhandenen Texte, Bilder, Fotos, Videos oder Grafiken
                                unterliegen in der Regel dem Schutz des Urheberrechts. Jede unberechtigte Verwendung
                                (insbesondere die Vervielfältigung, Bearbeitung oder Verbreitung) dieser
                                urheberrechtsgeschützten Inhalte ist daher untersagt. Wenn Sie beabsichtigen, diese
                                Inhalte oder Teile davon zu verwenden, kontaktieren Sie uns bitte im Voraus unter den
                                oben stehenden Angaben. Soweit wir nicht selbst Inhaber der benötigten
                                urheberrechtlichen Nutzungsrechte sein sollten, bemühen wir uns, einen Kontakt zum
                                Berechtigten zu vermitteln.</p>


                            <h3 class="text-left">Social Media-Profile</h3>
                            <p>Dieses Impressum gilt auch für folgende Social Media-Profile: <a href="https://www.facebook.com/dgastro24">Facebook</a>, <a href="https://www.twitter.com/">Twitter</a>, <a href="https://instagram.com">Instagram</a></p>
					</div><!--impressum-->
				</div>
			</div>
		</div>		
	</div>
    <!-- Content END-->

	<!-- Footer -->
    <footer class="site-footer footer-white bridal-footer">
		<div class="footer-top">
            <div class="container">
				<div class="dlab-divider bg-gray-dark"><i class="icon-dot c-square"></i></div>				
                <div class="row d-flex dzfooter-info">
					<div class="col-xl-3 col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h6>{LANG_PHONE} &amp; {LANG_EMAIL_ADDRESS}</h6>
                            <ul>
								IF("{PHONE}"!=""){
                                <li><i class="fa fa-phone"></i><a href="tel:{PHONE}">{PHONE}</a> <br>
								{:IF}
								IF("{EMAIL}"!=""){
									<i class="fa fa-envelope"></i><a href="mailto:{EMAIL}">{EMAIL}</a></li>
								{:IF}
                            </ul>
                        </div>
                    </div>
					<div class="col-xl-3 col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h6>{LANG_ADDRESS}</h6>
                            <ul>
                                <li><i class="fa fa-map-marker"></i><a target="_blank" href="https://maps.google.com/?q={ADDRESS}">{ADDRESS}</a></li>
                            </ul>
                        </div>
                    </div>
					<div class="col-xl-6 col-12 col-lg-6 col-md-12 col-sm-12">
                        <div class="widget">
                            <h6>{LANG_OPEN_HOUR}</h6>
                            <ul class="dzopen-hour-list" style="width:100%;">
								<li>{LANG_MONDAY} <span>{OPEN_HOUR_2}</span></li>
								<li>{LANG_TUESDAY} <span>{OPEN_HOUR_3}</span></li>
								<li>{LANG_WEDNESDAY}<span>{OPEN_HOUR_4}</span></li>
								<li>{LANG_THURSDAY} <span>{OPEN_HOUR_5}</span></li>
								<li>{LANG_FRIDAY} <span>{OPEN_HOUR_6}</span></li>
								<li>{LANG_SATURDAY} <span>{OPEN_HOUR_7}</span></li>
								<li>{LANG_SUNDAY} <span>{OPEN_HOUR_1}</span></li>
							</ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
		
		<div class="container dzbottom-line">
			<div class="row">
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text"><a href="">{COPYRIGHT_TEXT}</a></div>
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text text-right">
					<a class="right-ft-link" href="{LINK_AGB_RESTAURANTS}?id={SHOP_ID}">AGB</a>
					<a class="right-ft-link" href="{LINK_DATA_PROTECTION_RESTAURANTS}?id={SHOP_ID}">Datenschutzerklärung</a>
					<a class="right-ft-link" href="{LINK_IMPRESSUM_RESTAURANTS}?id={SHOP_ID}">Impressum</a>
				</div>
			</div>
		</div>
    </footer>	
    <!-- Footer END-->
    <button class="scroltop fa fa-chevron-up" ></button>
</div>

<!-- JAVASCRIPT FILES ========================================= -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/custom.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.cookie.min.js?v={VERSION}"></script><!-- SHOP API  -->
<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/customer.js.php?v={VERSION}&t={SHOP_TIME_NOW}"></script>

<script type="text/javascript">
	$(function(){
		$('.sidebar a.dez-page').click(function(){
			var link = $(this).prop('href');
			try{
				$('.sidebar').find('li').removeClass('active');
				let hash = link.split('#')[1];
				let elm = $('#' + hash);
				$(this).parent().addClass('active');
				$('body,html').animate({'scroll-top' : elm.offset().top}, 'slow');
			}catch(e){

			}
		});
	});
</script>
</body>
<style>
	.privacy-container{

	}
	.privacy-container h1, .privacy-container h2{
		font-size:32px;
	}
	.privacy-container h1{
		font-size:42px;
	}
	.privacy-container p{
		font-size:18px;line-height: 32px;
		margin-bottom:12px;
		text-align: justify;
	}
	.privacy-container .sidebar{
		padding-left: 15px;
	}
	.privacy-container .sidebar ul{
		list-style: none !important;
	}
	.privacy-container .sidebar ul li{
		display: block !important;		
		margin:5px 0;		
	}
	.privacy-container .sidebar ul li a{
		font-size:18px;
		color:  var(--classic-color-1);
		width:100% !important;
		display: inline-block;
		padding:5px 15px;
		border-radius: 4px;
		border:1px solid var(--classic-color-0_2);		
	}
	.privacy-container .sidebar ul li:hover a, .privacy-container .sidebar ul li.active a{
		background-color:  var(--classic-color-1);
		color:#FFF !important;
	}
	.privacy-content a{
		color: var(--classic-color-1);
	}
	.privacy-content p strong{font-weight: 600;}
</style>
</html>

