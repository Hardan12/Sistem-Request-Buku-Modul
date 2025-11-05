<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Request Buku & Modul</title>
    <link rel="icon" href="images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="a.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        h1 {
            font-weight: bold;
            animation: fadeIn 2s ease-in-out;
        }

        h6 {
            font-size: 18px;
            margin-bottom: 20px;
            animation: fadeIn 2.5s ease-in-out;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .button-group a {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .button-group a:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #009688;
        }

        .btn-secondary {
            background-color: blueviolet;
        }

        .centered {
            text-align: center;
            padding-top: 150px;
            animation: fadeInUp 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .button-group {
                flex-direction: column;
                gap: 10px;
            }

            .button-group a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body class="hero-anime">

    <div class="navigation-wrap bg-light start-header start-style">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="index.php"><img src="images/LogoPCR.png" alt=""></a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto py-4 py-md-0">
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="../views/auth/auth.php"><button class="btn btn-primary">Login</button></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="section full-height">
        <div class="absolute-center">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="centered">
                                    <h1 class="text-background">Sistem Request Buku & Modul</h1>
                                    <h6 class="text-background">Ajukan pembelian buku dan modul pembelajaran,<br>
                                        untuk mendukung kegiatan perkuliahan</h6>
                                </div>
                                <div class="button-group">
                                    <a href="views/buku/BookFormView.php" class="btn-primary"><span>Request Buku</span></a>
                                    <a href="views/modul/ModulFormView.php" class="btn-primary"><span>Request Modul</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function($) {
            "use strict";

            $(function() {
                var header = $(".start-style");
                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();

                    if (scroll >= 10) {
                        header.removeClass('start-style').addClass("scroll-on");
                    } else {
                        header.removeClass("scroll-on").addClass('start-style');
                    }
                });
            });

            //Animation

            $(document).ready(function() {
                $('body.hero-anime').removeClass('hero-anime');
            });

            //Menu On Hover

            $('body').on('mouseenter mouseleave', '.nav-item', function(e) {
                if ($(window).width() > 750) {
                    var _d = $(e.target).closest('.nav-item');
                    _d.addClass('show');
                    setTimeout(function() {
                        _d[_d.is(':hover') ? 'addClass' : 'removeClass']('show');
                    }, 1);
                }
            });

            //Switch light/dark

            $("#switch").on('click', function() {
                if ($("body").hasClass("dark")) {
                    $("body").removeClass("dark");
                    $("#switch").removeClass("switched");
                } else {
                    $("body").addClass("dark");
                    $("#switch").addClass("switched");
                }
            });

        })(jQuery);
    </script>
</body>

</html>