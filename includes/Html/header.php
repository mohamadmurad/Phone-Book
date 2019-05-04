<?php ob_start(); 

 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">    
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Telephone book | Save All Your Contact In One Place | Easy To Add , Search,Edit And Delete">
       <!-- <meta  name="keywords" content="contact">
        <link rel="publisher" href="https://www.facebook.com/eng.ITE">
        <meta name="article:publisher" content="https://www.facebook.com/eng.ITE">-->
        <!--<meta property="fb:admins" content="100011400505395">-->
        <meta name='geo.country' content='Syria' />
        <meta property='article:author' content='https://www.facebook.com/eng.ITE' />
        <meta property='article:publisher' content='https://www.facebook.com/eng.ITE' />
        <meta property='og:locale' content='ar_AR'/>
        <meta property='og:title' content='<?php echo $pageTite ?>'/>
        <meta property="og:site_name" content="Telephone Book"/>
        <meta property="og:type" content="website"/>
        <meta property='og:image' content='public/images/bg.jpg' />
        <meta name='og:description' content='Save All Your Contact In One Place | Easy To Add , Search,Edit And Delete' />
        <meta name="author" content="Mohamad Murad">
        <meta name="robots" content="index, follow" />
        <meta name="googlebot" content="index, follow" />
        <title><?php echo $pageTite ?></title>
        
        <link rel="shortcut icon" href="public/images/Phonebook-icon.png">
        
        <!-- Chrome, Firefox OS, Opera and Vivaldi -->
        <meta name="theme-color" content="#4ab4e8">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#4ab4e8">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#4ab4e8">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <link rel="stylesheet" href="<?php echo Config::get("target/css"); ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Config::get("target/fontawesome"); ?>css/all.min.css">
        <link rel="stylesheet" href="<?php echo Config::get("target/css"); ?>phones1.css?v=2">
       

    </head>
    <body>