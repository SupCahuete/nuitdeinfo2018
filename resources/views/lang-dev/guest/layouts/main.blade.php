<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Meta -->
  <meta name="author" content="@config('app.author')">
  <meta name="identifier-url" content="@config('app.url')">
  <meta name="copyright" content="@config('app.copyright')">
  <meta name="keywords" content="">
  @yield('meta')
  
  <!-- Favicon -->
  <link rel="apple-touch-icon" type="image/png" href="/favicon.png">
  <link rel="shortcut icon" type="image/png" href="/favicon.png" sizes="32x32">
  {{--<link rel="shortcut icon" type="image/png" href="favicon-16x16.png" sizes="16x16">--}}
  <meta name="apple-mobile-web-app-title" content="@config('app.name')">
  <meta name="application-name" content="@config('app.name')">
  <meta name="theme-color" content="#ffffff">
  @yield('favicon')
  
  <!-- Facebook -->
  <meta property="og:image" content="">
  @yield('facebook')
  
  <!-- Twitter -->
  <meta name="twitter:image" content="">
  @yield('twitter')
  
  <!-- Linkedin -->
  @yield('linkedin')
  
  <!-- Google -->
  <meta name="google-site-verification" content="" />
  @yield('google')
  
  <!-- Cookies Consent -->
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
  <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
  <script>
    window.addEventListener("load", function(){
      window.cookieconsent.initialise({
        "palette": {
          "popup": {
            "background": "#F55F5A",
            "text": "#FFFFFF"
          },
          "button": {
            "background": "#61C7E4",
            "text": "#FFFFFF"
          }
        },
        "theme": "edgeless",
        "content": {
          "message": "{!! trans("cookies-consent.message") !!}",
          "dismiss": "{!! trans("cookies-consent.dismiss") !!}",
          "href": "http://cookies.insites.com/"
        }
      })});
  </script>
  
  <!-- Le Style ma chérie !!!!! #Christina -->
  <link rel="stylesheet" type="text/css" href="@css('materialize.min.css')" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  @yield('style')
  
  <!-- Le script de tête, sauf si le fichier fait le poirier là ce serait un script de pied -->
  @yield('script-head')
  
  <!-- Le truc qui s'affiche dans l'onglet en haut -->
  <title>@yield('title')</title>
</head>

<body>

  <!--

  Toi qui est perdu dans le désert à faire je sais pas trop quoi de scientifique, voilà un texte pour te remonter (ou pas) le moral:

  Mais, vous savez, moi je ne crois pas
  qu'il y ait de bonne ou de mauvaise situation.
  Moi, si je devais résumer ma vie aujourd'hui avec vous,
  je dirais que c'est d'abord des rencontres,
  Des gens qui m'ont tendu la main,
  peut-être à un moment où je ne pouvais pas, où j'étais seul chez moi.
  Et c'est assez curieux de se dire que les hasards,
  les rencontres forgent une destinée...
  Parce que quand on a le goût de la chose,
  quand on a le goût de la chose bien faite,
  Le beau geste, parfois on ne trouve pas l'interlocuteur en face,
  je dirais, le miroir qui vous aide à avancer.
  Alors ce n'est pas mon cas, comme je le disais là,
  puisque moi au contraire, j'ai pu ;
  Et je dis merci à la vie, je lui dis merci,
  je chante la vie, je danse la vie... Je ne suis qu'amour!
  Et finalement, quand beaucoup de gens aujourd'hui me disent :
  "Mais comment fais-tu pour avoir cette humanité ?",
  Eh bien je leur réponds très simplement,
  je leur dis que c'est ce goût de l'amour,
  Ce goût donc qui m'a poussé aujourd'hui
  à entreprendre une construction mécanique,
  Mais demain, qui sait, peut-être simplement
  à me mettre au service de la communauté,
  à faire le don, le don de soi...


  PS: Pourquoi t'inspecte le code d'ailleurs? T'as rien de mieux à faire, genre marcher dans du sable?

  Du coup, on va jouer à un jeu qui s'appelle vas-y scroll. C'est un peu comme Elder Scroll mais avec moins de dragons et plus de crampes au doigt.

  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  Encore un effort
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  Voilà
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  Mais en fait non
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  The cake is a lie
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  .
  Allez c'est bon, vous y êtes.

  -->

  
  <!-- Je trouve pas de vanne, à chercher plus tard -->
  <div id="mainContainer">
    <div id="mainAlert">
      @if ($errors = $errors->all())
        <div class="alert-errors">
  
          @foreach($errors as $error)
            <p class="alert-error">{{ $error }}</p>
          @endforeach
  
        </div>
      @endif
  
      @if ($errors = Session::get('error'))
        <div class="alert-errors">
  
          @foreach($errors as $error)
            <p class="alert-error">{{ $error }}</p>
          @endforeach
  
        </div>
      @endif
  
      @if($success = Session::get('success'))
        <div class="alert-success">
  
          @foreach($success as $s)
            <p class="info-success">{{ $s }}</p>
          @endforeach
  
        </div>
      @endif
  
      @yield('alert')
    </div>

    <!-- C'est la qu'on inclut notre device trop classe, toute ressemblance avec un appareil d'un certain jeu video serait purement fortuite -->
    <svg id="device" width="1352" height="917" viewBox="0 0 1352 917" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M285.5 689V163.5L348 105.5H1165L1224.5 163.5V746.5L1103 872.5H651.5L519.5 746.5H348L285.5 689Z" fill="url(#paint0_linear)"/>
      <foreignObject id="contentContainer" x="360" y="177" width="800" height="500">
        @include('guest.layouts.menu')
        @yield('content')
      </foreignObject>
      <g filter="url(#filter0_d)">
      <rect x="661" y="742" width="197" height="97" fill="url(#paint1_radial)"/>
      </g>
      <g filter="url(#filter1_d)">
      <ellipse cx="943.5" cy="741.5" rx="26.5" ry="25.5" fill="url(#paint2_radial)"/>
      </g>
      <g filter="url(#filter2_d)">
      <ellipse cx="943.5" cy="813.5" rx="26.5" ry="25.5" fill="url(#paint3_radial)"/>
      </g>
      <path d="M998.504 750.24C997.176 750.24 995.592 750.112 993.752 749.856V747.912C995.608 748.312 997.24 748.512 998.648 748.512C999.832 748.512 1000.7 748.384 1001.24 748.128C1001.78 747.856 1002.06 747.36 1002.06 746.64V744.624C1002.06 743.952 1001.86 743.48 1001.48 743.208C1001.1 742.936 1000.42 742.8 999.464 742.8H997.64C996.12 742.8 995.04 742.496 994.4 741.888C993.76 741.28 993.44 740.336 993.44 739.056V737.808C993.44 736.96 993.624 736.272 993.992 735.744C994.376 735.216 995.008 734.824 995.888 734.568C996.784 734.312 998.008 734.184 999.56 734.184C1000.6 734.184 1001.94 734.272 1003.57 734.448V736.2C1001.74 735.928 1000.35 735.792 999.392 735.792C997.904 735.792 996.92 735.936 996.44 736.224C995.944 736.528 995.696 737.032 995.696 737.736V739.512C995.696 740.056 995.888 740.456 996.272 740.712C996.672 740.952 997.352 741.072 998.312 741.072H1000.18C1001.26 741.072 1002.09 741.2 1002.68 741.456C1003.29 741.712 1003.71 742.104 1003.95 742.632C1004.21 743.144 1004.34 743.84 1004.34 744.72V745.848C1004.34 746.952 1004.13 747.824 1003.71 748.464C1003.31 749.104 1002.69 749.56 1001.84 749.832C1000.99 750.104 999.88 750.24 998.504 750.24ZM1010.3 750.168L1005.81 738.384H1008.16L1011.4 747.864H1011.45L1014.38 738.384H1016.56L1010.73 754.992H1008.47L1010.3 750.168ZM1022.13 750.24C1020.9 750.24 1019.57 750.144 1018.14 749.952V748.296C1020.02 748.6 1021.36 748.752 1022.18 748.752C1023.2 748.752 1023.94 748.656 1024.38 748.464C1024.83 748.256 1025.06 747.88 1025.06 747.336V746.16C1025.06 745.664 1024.89 745.312 1024.55 745.104C1024.22 744.896 1023.67 744.792 1022.92 744.792H1021.6C1020.4 744.792 1019.48 744.544 1018.84 744.048C1018.22 743.552 1017.9 742.856 1017.9 741.96V740.88C1017.9 739.056 1019.63 738.144 1023.09 738.144C1023.34 738.144 1024.52 738.208 1026.62 738.336V739.896C1025.19 739.672 1023.98 739.56 1022.99 739.56C1021.86 739.56 1021.08 739.672 1020.66 739.896C1020.25 740.12 1020.04 740.496 1020.04 741.024V742.008C1020.04 742.792 1020.75 743.184 1022.18 743.184H1023.52C1025.97 743.184 1027.19 744.096 1027.19 745.92V746.928C1027.19 748.128 1026.78 748.984 1025.94 749.496C1025.11 749.992 1023.84 750.24 1022.13 750.24ZM1035.05 750.24C1034.06 750.24 1033.28 750.136 1032.72 749.928C1032.16 749.704 1031.75 749.336 1031.5 748.824C1031.26 748.296 1031.14 747.56 1031.14 746.616V739.8H1028.54V738.384H1031.14V734.784H1033.32V738.384H1037.47V739.8H1033.32V746.736C1033.32 747.312 1033.38 747.744 1033.51 748.032C1033.66 748.32 1033.9 748.528 1034.23 748.656C1034.58 748.768 1035.09 748.824 1035.74 748.824C1035.95 748.824 1036.53 748.76 1037.47 748.632V750.048C1036.66 750.176 1035.85 750.24 1035.05 750.24ZM1044.73 750.24C1041.18 750.24 1039.4 749.056 1039.4 746.688V742.104C1039.4 740.696 1039.8 739.688 1040.6 739.08C1041.42 738.456 1042.73 738.144 1044.54 738.144C1046.25 738.144 1047.48 738.44 1048.23 739.032C1049 739.624 1049.38 740.648 1049.38 742.104V744.672H1041.58V746.424C1041.58 747.224 1041.86 747.8 1042.42 748.152C1042.98 748.504 1043.85 748.68 1045.02 748.68C1046.12 748.68 1047.42 748.488 1048.93 748.104V749.76C1047.46 750.08 1046.06 750.24 1044.73 750.24ZM1047.22 743.256V741.432C1047.22 740.728 1047.01 740.248 1046.58 739.992C1046.16 739.72 1045.44 739.584 1044.42 739.584C1043.42 739.584 1042.7 739.72 1042.26 739.992C1041.81 740.248 1041.58 740.728 1041.58 741.432V743.256H1047.22ZM1040.41 733.68H1043.02L1045.18 736.728H1043.41L1040.41 733.68ZM1052.68 738.384H1054.84V739.8C1055.06 738.696 1056.36 738.144 1058.75 738.144C1060.68 738.144 1061.89 738.672 1062.37 739.728C1062.52 739.216 1062.95 738.824 1063.67 738.552C1064.4 738.28 1065.3 738.144 1066.36 738.144C1067.8 738.144 1068.81 738.416 1069.4 738.96C1070 739.488 1070.29 740.328 1070.29 741.48V750H1068.13V741.624C1068.13 741.32 1068.11 741.072 1068.06 740.88C1068.01 740.688 1067.92 740.496 1067.77 740.304C1067.45 739.904 1066.74 739.704 1065.64 739.704C1064.79 739.704 1064.16 739.76 1063.74 739.872C1063.32 739.984 1063.04 740.176 1062.88 740.448C1062.73 740.72 1062.66 741.112 1062.66 741.624V750H1060.5V741.624C1060.5 741.32 1060.48 741.072 1060.43 740.88C1060.38 740.688 1060.28 740.496 1060.14 740.304C1059.82 739.904 1059.12 739.704 1058.03 739.704C1057.15 739.704 1056.48 739.76 1056.04 739.872C1055.59 739.984 1055.28 740.176 1055.1 740.448C1054.92 740.704 1054.84 741.096 1054.84 741.624V750H1052.68V738.384ZM1078.92 750.24C1075.37 750.24 1073.6 749.056 1073.6 746.688V742.104C1073.6 740.696 1074 739.688 1074.8 739.08C1075.61 738.456 1076.92 738.144 1078.73 738.144C1080.44 738.144 1081.68 738.44 1082.43 739.032C1083.2 739.624 1083.58 740.648 1083.58 742.104V744.672H1075.78V746.424C1075.78 747.224 1076.06 747.8 1076.62 748.152C1077.18 748.504 1078.04 748.68 1079.21 748.68C1080.32 748.68 1081.62 748.488 1083.12 748.104V749.76C1081.65 750.08 1080.25 750.24 1078.92 750.24ZM1081.42 743.256V741.432C1081.42 740.728 1081.2 740.248 1080.77 739.992C1080.36 739.72 1079.64 739.584 1078.61 739.584C1077.62 739.584 1076.9 739.72 1076.45 739.992C1076 740.248 1075.78 740.728 1075.78 741.432V743.256H1081.42Z" fill="#BEBEBE"/>
      <path d="M998.504 823.24C997.176 823.24 995.592 823.112 993.752 822.856V820.912C995.608 821.312 997.24 821.512 998.648 821.512C999.832 821.512 1000.7 821.384 1001.24 821.128C1001.78 820.856 1002.06 820.36 1002.06 819.64V817.624C1002.06 816.952 1001.86 816.48 1001.48 816.208C1001.1 815.936 1000.42 815.8 999.464 815.8H997.64C996.12 815.8 995.04 815.496 994.4 814.888C993.76 814.28 993.44 813.336 993.44 812.056V810.808C993.44 809.96 993.624 809.272 993.992 808.744C994.376 808.216 995.008 807.824 995.888 807.568C996.784 807.312 998.008 807.184 999.56 807.184C1000.6 807.184 1001.94 807.272 1003.57 807.448V809.2C1001.74 808.928 1000.35 808.792 999.392 808.792C997.904 808.792 996.92 808.936 996.44 809.224C995.944 809.528 995.696 810.032 995.696 810.736V812.512C995.696 813.056 995.888 813.456 996.272 813.712C996.672 813.952 997.352 814.072 998.312 814.072H1000.18C1001.26 814.072 1002.09 814.2 1002.68 814.456C1003.29 814.712 1003.71 815.104 1003.95 815.632C1004.21 816.144 1004.34 816.84 1004.34 817.72V818.848C1004.34 819.952 1004.13 820.824 1003.71 821.464C1003.31 822.104 1002.69 822.56 1001.84 822.832C1000.99 823.104 999.88 823.24 998.504 823.24ZM1011.11 823.24C1010.01 823.24 1009.15 823.136 1008.54 822.928C1007.95 822.72 1007.52 822.352 1007.25 821.824C1006.99 821.296 1006.86 820.536 1006.86 819.544C1006.86 818.664 1006.98 817.984 1007.22 817.504C1007.48 817.008 1007.9 816.656 1008.5 816.448C1009.1 816.24 1009.96 816.136 1011.06 816.136H1014.54V814.288C1014.54 813.856 1014.46 813.528 1014.28 813.304C1014.12 813.064 1013.84 812.896 1013.44 812.8C1013.06 812.704 1012.49 812.656 1011.74 812.656C1010.54 812.656 1009.21 812.752 1007.75 812.944V811.36C1009.34 811.216 1010.77 811.144 1012.05 811.144C1013.39 811.144 1014.38 811.248 1015.02 811.456C1015.66 811.648 1016.1 811.992 1016.34 812.488C1016.58 812.984 1016.7 813.752 1016.7 814.792V823H1014.62V821.896C1014.44 822.792 1013.27 823.24 1011.11 823.24ZM1011.47 821.824C1012.26 821.824 1012.92 821.768 1013.46 821.656C1014.18 821.512 1014.54 821.176 1014.54 820.648V817.48H1011.21C1010.52 817.48 1010.02 817.536 1009.72 817.648C1009.42 817.744 1009.22 817.936 1009.12 818.224C1009.02 818.512 1008.98 818.976 1008.98 819.616C1008.98 820.192 1009.03 820.64 1009.14 820.96C1009.26 821.264 1009.46 821.488 1009.74 821.632C1010.03 821.76 1010.46 821.824 1011.04 821.824H1011.47ZM1025.32 823.24C1024.33 823.24 1023.55 823.136 1022.99 822.928C1022.43 822.704 1022.03 822.336 1021.77 821.824C1021.53 821.296 1021.41 820.56 1021.41 819.616V812.8H1018.82V811.384H1021.41V807.784H1023.59V811.384H1027.75V812.8H1023.59V819.736C1023.59 820.312 1023.66 820.744 1023.79 821.032C1023.93 821.32 1024.17 821.528 1024.51 821.656C1024.86 821.768 1025.36 821.824 1026.02 821.824C1026.23 821.824 1026.8 821.76 1027.75 821.632V823.048C1026.93 823.176 1026.12 823.24 1025.32 823.24ZM1035.78 807.424H1038.11V821.368H1045.77V823H1035.78V807.424ZM1048.11 807.184H1050.27V809.44H1048.11V807.184ZM1048.11 811.384H1050.27V823H1048.11V811.384ZM1054.01 811.384H1056.17V812.8C1056.4 811.696 1057.67 811.144 1059.99 811.144C1061.48 811.144 1062.52 811.416 1063.11 811.96C1063.72 812.488 1064.02 813.328 1064.02 814.48V823H1061.86V814.6C1061.86 814.296 1061.84 814.048 1061.79 813.856C1061.74 813.664 1061.64 813.472 1061.5 813.28C1061.18 812.88 1060.47 812.68 1059.36 812.68C1058.52 812.68 1057.86 812.744 1057.4 812.872C1056.95 812.984 1056.63 813.176 1056.44 813.448C1056.26 813.72 1056.17 814.104 1056.17 814.6V823H1054.01V811.384ZM1067.77 806.2H1069.93V823H1067.77V806.2ZM1070.19 816.64L1075.09 811.384H1077.73L1072.69 816.64L1078.19 823H1075.5L1070.19 816.64Z" fill="#BEBEBE"/>
      <path d="M713.688 814.64C710.146 814.64 705.922 814.299 701.016 813.616V808.432C705.965 809.499 710.317 810.032 714.072 810.032C717.229 810.032 719.533 809.691 720.984 809.008C722.434 808.283 723.16 806.96 723.16 805.04V799.664C723.16 797.872 722.648 796.613 721.624 795.888C720.6 795.163 718.808 794.8 716.248 794.8H711.384C707.33 794.8 704.45 793.989 702.744 792.368C701.037 790.747 700.184 788.229 700.184 784.816V781.488C700.184 779.227 700.674 777.392 701.656 775.984C702.68 774.576 704.365 773.531 706.712 772.848C709.101 772.165 712.365 771.824 716.504 771.824C719.277 771.824 722.84 772.059 727.192 772.528V777.2C722.328 776.475 718.616 776.112 716.056 776.112C712.088 776.112 709.464 776.496 708.184 777.264C706.861 778.075 706.2 779.419 706.2 781.296V786.032C706.2 787.483 706.712 788.549 707.736 789.232C708.802 789.872 710.616 790.192 713.176 790.192H718.168C721.026 790.192 723.245 790.533 724.824 791.216C726.445 791.899 727.576 792.944 728.216 794.352C728.898 795.717 729.24 797.573 729.24 799.92V802.928C729.24 805.872 728.685 808.197 727.576 809.904C726.509 811.611 724.845 812.827 722.584 813.552C720.322 814.277 717.357 814.64 713.688 814.64ZM754.413 814.64C742.808 814.64 737.005 810.885 737.005 803.376V783.728C737.005 775.792 742.808 771.824 754.413 771.824C766.147 771.824 772.013 775.771 772.013 783.664V803.376C772.013 807.387 770.392 810.267 767.149 812.016C763.907 813.765 759.661 814.64 754.413 814.64ZM754.541 810.48C762.179 810.48 765.997 808.091 765.997 803.312V783.536C765.997 778.416 762.157 775.856 754.477 775.856C750.765 775.856 747.907 776.432 745.901 777.584C743.939 778.736 742.957 780.72 742.957 783.536V803.312C742.957 808.091 746.819 810.48 754.541 810.48ZM793.563 814.64C790.021 814.64 785.797 814.299 780.891 813.616V808.432C785.84 809.499 790.192 810.032 793.947 810.032C797.104 810.032 799.408 809.691 800.859 809.008C802.309 808.283 803.035 806.96 803.035 805.04V799.664C803.035 797.872 802.523 796.613 801.499 795.888C800.475 795.163 798.683 794.8 796.123 794.8H791.259C787.205 794.8 784.325 793.989 782.619 792.368C780.912 790.747 780.059 788.229 780.059 784.816V781.488C780.059 779.227 780.549 777.392 781.531 775.984C782.555 774.576 784.24 773.531 786.587 772.848C788.976 772.165 792.24 771.824 796.379 771.824C799.152 771.824 802.715 772.059 807.067 772.528V777.2C802.203 776.475 798.491 776.112 795.931 776.112C791.963 776.112 789.339 776.496 788.059 777.264C786.736 778.075 786.075 779.419 786.075 781.296V786.032C786.075 787.483 786.587 788.549 787.611 789.232C788.677 789.872 790.491 790.192 793.051 790.192H798.043C800.901 790.192 803.12 790.533 804.699 791.216C806.32 791.899 807.451 792.944 808.091 794.352C808.773 795.717 809.115 797.573 809.115 799.92V802.928C809.115 805.872 808.56 808.197 807.451 809.904C806.384 811.611 804.72 812.827 802.459 813.552C800.197 814.277 797.232 814.64 793.563 814.64Z" fill="white"/>
      <defs>
      <filter id="filter0_d" x="656" y="741" width="207" height="107" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="2.5"/>
      <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <filter id="filter1_d" x="913" y="716" width="61" height="59" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="2"/>
      <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <filter id="filter2_d" x="913" y="788" width="61" height="59" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
      <feFlood flood-opacity="0" result="BackgroundImageFix"/>
      <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
      <feOffset dy="4"/>
      <feGaussianBlur stdDeviation="2"/>
      <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
      <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
      <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <linearGradient id="paint0_linear" x1="652" y1="50" x2="652" y2="975.283" gradientUnits="userSpaceOnUse">
      <stop stop-color="#646262"/>
      <stop offset="0.171271" stop-color="#393939"/>
      <stop offset="0.801105" stop-color="#424242"/>
      <stop offset="1" stop-color="#605F5F"/>
      </linearGradient>
      <radialGradient id="paint1_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(759.5 790.5) rotate(90) scale(48.5 98.5)">
      <stop stop-color="#C51B1B"/>
      <stop offset="1" stop-color="#C03636"/>
      </radialGradient>
      <radialGradient id="paint2_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(943.5 741.5) rotate(90) scale(25.5 26.5)">
      <stop stop-color="#13B110"/>
      <stop offset="1" stop-color="#167214"/>
      </radialGradient>
      <radialGradient id="paint3_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(943.5 813.5) rotate(90) scale(25.5 26.5)">
      <stop stop-color="#13B110"/>
      <stop offset="1" stop-color="#167214"/>
      </radialGradient>
      </defs>
    </svg>
  </div>
  
  <!-- Attention: ça sent les pieds -->
  <footer >
  </footer>
  
  <!-- Script Body -->
  <script type="text/javascript" src="@asset_url_js('jquery.js')"></script>
  <script type="text/javascript" src="@asset_url_js('main.js')"></script>
  @yield('script-body')
</body>
</html>
