<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="<?= esc($themeColor) ?>">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="/css/rubikglitch/css/all.css">
    <link rel="stylesheet" href="/css/material-icons/css/all.css">
    <link rel="stylesheet" href="/css/main.css">
    <script type="text/javascript" defer src="/js/abstracts/transition.js"></script>
    <script type="text/javascript" defer src="/js/components/authentication.js"></script>
    <script type="text/javascript" defer src="/js/components/dropdown.js"></script>
    <script type="text/javascript" defer src="/js/components/main-menu-toggle.js"></script>
    <script type="text/javascript" defer src="/js/components/language-switcher.js"></script>
    <script type="text/javascript" defer src="/js/components/theme-switcher.js"></script>
    <script type="text/javascript" defer src="/js/components/recaptcha.js"></script>
    <script type="text/javascript" defer src='https://www.google.com/recaptcha/api.js?hl=<?= esc($locale) ?>&onload=onloadCallback&render=explicit'></script>
    <link rel="icon" href="favicon.ico">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body class="<?= esc($theme) ?>">
