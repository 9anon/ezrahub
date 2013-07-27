<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <title>Ezra Hub | @yield('title')</title>
        <meta name="description" content="@yield('description')"/>
        <meta name="author" content="{{ Config::get('ezrahub.admin_email') }}"/>
        <meta name="viewport" content="width=device-width"/>
        @yield('canonical')
        <link rel="stylesheet/less" type="text/css" href="/css/main.css" media="all">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster" media="all">
        <link rel="stylesheet"type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" media="all">
        <script src="/js/less-1.3.3.min.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <a href="/">
                    <span class="hover-container">
                        <img class="ezra" src="/img/ezra.png" width="71" height="50" alt="ezra hub cornell">
                        <span class="icon-home"></span>
                    </span>
                    <h1 class="title">ezra hub</h1>
                </a>
                <nav class="main-nav">
                    <ul class="main-nav">
                        <li class="search-bar">
                            <span class="icon-left icon-search"></span>
                            <?php echo Form::open('search', 'POST'); ?>
                                @include('layout.placeholderfill')
                                <?php echo Form::text('search-input', null, array('placeholder' => random_placeholder())); ?>
                            <?php echo Form::close(); ?>
                        </li>
                        <li>
                            <a href="/about" class="browse-option about">
                                <span class="icon-left icon-info-sign"></span> About
                            </a>
                        </li>
                        <li>
                            <a href="/rules" class="browse-option rules">
                                <span class="icon-left icon-legal"></span> Rules
                            </a>
                        </li>
                        <li>
                            <a href ="http://wnajar.github.io/ezrahub" class="browse-option github">
                                <span class="icon-left icon-github"></span>
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="https://twitter.com/ezrahub" class="top-bar">
                                <span class="icon-twitter"></span>
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.facebook.com/ezrahub" class="top-bar">
                                <span class="icon-facebook-sign"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </header>
            <main>
                {{ $content }}
            </main>
        </div>
        @include('layout.footer')
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
        <script>window.jQuery || document.write('<script src="/js/jquery-1.9.1.min.js"><\/script>')</script>
        {{ HTML::script('js/plugins.js') }}
        {{ HTML::script('js/main.js') }}
        <script>var _gaq=_gaq||[];_gaq.push(['_setAccount','UA-37389599-1']);_gaq.push(['_trackPageview']);(function(){var ga=document.createElement('script');ga.type='text/javascript';ga.async=true;ga.src=('https:'==document.location.protocol?'https://ssl':'http://www')+'.google-analytics.com/ga.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga,s);})();</script>
        <div id="back-to-top"><a href="#"><span class="icon-angle-up"></span></a></div>
        <div id="loading-indicator">
            <img id="loading-image" src="/img/loading.gif" alt="loading" width="43" height="11">
            Loading...
        </div>
    </body>
</html>
