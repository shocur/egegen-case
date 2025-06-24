<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Egegen Frontend Task</title>
        <link rel="stylesheet" href="/assets/css/style.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <h1 style="text-align: center;margin-bottom:80px;">Egegen Frontend Task</h1>

        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Header</h2>
         <header style="margin-bottom:100px">
            <div class="logo">
                <img src="/assets/img/egegen-logo.png" width="80" alt=""> EGEGEN
            </div>
            <nav class="nav">
            <div class="nav-item">Anasayfa</div>
            <div class="nav-item">Hakkımızda</div>
            <div class="nav-item">Hizmetler
                <div class="dropdown">
                <a href="#">Web Tasarım</a>
                <a href="#">Yazılım</a>
                <a href="#">Destek</a>
                </div>
            </div>
            </nav>
        </header>

        <!-- GRID -->
        {{-- <div class="egegen-container">
            <div class="item col-5 row-2x"></div>
            <div class="item col-3 row-1x"></div>
            <div class="item col-3 row-1x"></div>
            <div class="item col-4 row-2x"></div>


            <div class="item col-3 row-1x"></div>
            <div class="item col-3 row-1x"></div>
            <div class="item col-3 row-1x"></div>

            <div class="item col-9"></div>
            <div class="item col-3"></div>
        </div> --}}

        
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Grid System</h2>
        <div class="grid-container" style="margin-bottom:100px">
            <div class="grid-item item-1"></div>
            <div class="grid-item item-2"></div>
            <div class="grid-item item-3"></div>
            <div class="grid-item item-4"></div>
            <div class="grid-item item-5"></div>
            <div class="grid-item item-6"></div>
            <div class="grid-item item-7"></div>
            <div class="grid-item item-8"></div>
            <div class="grid-item item-9"></div>
        </div>
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Accordion </h2>
        <div class="egegen-accordion">
            <div class="egegen-accordion-item">
                <div class="egegen-accordion-header">Başlık 1</div>
                <div class="egegen-accordion-content">İçerik</div>
            </div>
            <div class="egegen-accordion-item">
                <div class="egegen-accordion-header">Başlık 2</div>
                <div class="egegen-accordion-content">İçerik</div>
            </div>
            <div class="egegen-accordion-item">
                <div class="egegen-accordion-header">Başlık 3</div>
                <div class="egegen-accordion-content">İçerik</div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                // İlk öğeyi açıyoruz
                const firstItem = $('.egegen-accordion-item').first();
                firstItem.addClass('active');
                firstItem.find('.egegen-accordion-content').slideDown(200);

                $('.egegen-accordion-header').on('click', function () {
                    const item = $(this).parent();
                    const content = item.find('.egegen-accordion-content');

                    if (item.hasClass('active')) {
                        // Açık olan öğeye tekrar tıklanırsa sadece kapat
                        item.removeClass('active');
                        content.stop(true, true).slideUp(200);
                    } else {
                        // Diğer tüm öğeleri kapat
                        $('.egegen-accordion-item').removeClass('active');
                        $('.egegen-accordion-content').stop(true, true).slideUp(200);

                        // Bu öğeyi aç
                        item.addClass('active');
                        content.stop(true, true).slideDown(200);
                    }
                });
            });
        </script>
    </body>
</html>
