<?php
if (!isset($seo)) {
    $seo = (object) ['seo_title' => $siteSetting->site_name, 'seo_description' => $siteSetting->site_name, 'seo_keywords' => $siteSetting->site_name, 'seo_other' => ''];
}
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ session('localeDir', 'ltr') }}" dir="{{ session('localeDir', 'ltr') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __($seo->seo_title) }}</title>
    <meta name="Description" content="{!! $seo->seo_description !!}">
    <meta name="Keywords" content="{!! $seo->seo_keywords !!}">
    {!! $seo->seo_other !!}
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="http://etitc.edu.co/uploads/images/products/5f343aad0575e873393158.svg">
    <!-- Slider -->
    <link href="{{ asset('/') }}js/revolution-slider/css/settings.css" rel="stylesheet">
    <!-- Owl carousel -->
    <link href="{{ asset('/') }}css/owl.carousel.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('/') }}css/font-awesome.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="{{ asset('/') }}css/main.css?r=6" rel="stylesheet">

    @if (session('localeDir', 'ltr') == 'rtl')
        <!-- Rtl Style -->
        <link href="{{ asset('/') }}css/rtl-style.css" rel="stylesheet">
    @endif
    <link href="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/') }}admin_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/') }}admin_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    @stack('styles')

    <style>
        .transparent {
            background-color: rgba(0, 0, 0, 0.15);
        }


        @media only screen and (max-width: 600px) {

            .logo {
                max-width: 300% !important;
            }

        }

        @media only screen and (min-width: 600px) {

            .logo {
                max-width: 300% !important;
            }


            .responsive-image {
                max-width: 100%;
                height: auto;
            }

            @media screen and (min-width: 768px) {
                .responsive-image {
                    max-width: 50%;
                }
            }

            @media screen and (min-width: 1024px) {
                .responsive-image {
                    max-width: 500px;
                }
            }

        }


        /* Estilos para el tema oscuro */
        .dark-mode {
            color: #6ACA00 !important;
            background-color: #333;
        }

        .invert {
            color: #6ACA00 !important;
            filter: invert(100%);
        }

        .accessibility-buttons {
            position: fixed;
            top: 50%;
            right: 5px;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 9999;
            /* font-size: 20px; */
            /* padding: 10px; */
            border-radius: 90%;
        }

        .btn-accessibility {
            width: 40px;
            /* Ajusta el ancho según tus necesidades */
        }

        @media (max-width: 767px) {
            .accessibility-buttons {
                display: none;
            }
        }
    </style>

</head>

<body>

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script>
        function onClick(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
                grecaptcha.execute('6LfCXN8ZAAAAAEpFPox_HN8R8wo-mCtgCOE8vO4E', {
                    action: 'submit'
                }).then(function(token) {
                    // Add your logic to submit to your backend server here.
                });
            });
        }
    </script>


    @yield('content')


    <div class="accessibility-buttons">
        <button id="reset-font-size" class="btn btn-light btn-sm ">A</button>
        <button id="increase-font-size" class="btn btn-light btn-sm  ">A+</button>
        <button id="decrease-font-size" class="btn btn-light btn-sm ">A-</button>
        <button onclick="toggleDarkMode()" class="btn btn-light btn-sm ">DM</button>
    </div>




    <!-- Bootstrap's JavaScript -->

    <script src="{{ asset('/') }}js/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>



    <script src="{{ asset('/') }}js/owl.carousel.js"></script>
    <script src="{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>

    <script src="{{ asset('/') }}admin_assets/global/plugins/Bootstrap-3-Typeahead/bootstrap3-typeahead.min.js"
        type="text/javascript"></script>


    <script src="{{ asset('/') }}admin_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript">
    </script>
    <script src="{{ asset('/') }}admin_assets/global/plugins/jquery.scrollTo.min.js" type="text/javascript"></script>


    <script type="text/javascript" src="{{ asset('/') }}js/revolution-slider/js/jquery.themepunch.tools.min.js">
    </script>
    <script type="text/javascript" src="{{ asset('/') }}js/revolution-slider/js/jquery.themepunch.revolution.min.js">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



    {{-- {!! NoCaptcha::renderJs() !!} --}}

    @stack('scripts')

    <script src="{{ asset('/') }}js/script.js"></script>

    <script type="text/JavaScript">
        window.addEventListener('DOMContentLoaded', () => {

                                                                        const preferredMode = getCookie('ck');
                                                                        if (preferredMode === 'dm') toggleDarkMode()
                                                                        });

                $(document).ready(function(){

                    $('.textC').on('input',function(e){
                    var words= $(this).val().split(" ").length+$(this).val().split("\n").length-1
                    console.log(words,$(this).val(),e.target.innerHTML)
                    if(words>=250){
                    $(this).val(text)
                    }else{ 
                    text=$(this).val()
                    }
                    })
                    $("#description").on('keyup',function(){
                    console.log("paso");
                    })

                    $(".number-1").each(function() {$(this).val(currency($(this).val())); });
                    $(".number-1").on({
                    "focus": function (event) {
                    $(event.target).select();
                    },
                    "input":function (event) {
                    $(event.target).val(currency($(event.target).val()))
                    }

                    });


                    $('select').select2();

                    $(document).scrollTo('.has-error', 2000);
                    });
                    function currency(textCurrency){

                    var salary_from = textCurrency

                    console.log(salary_from,salary_from.includes('.00'))
                    salary_from=salary_from.replace('$','').replace(/,/g,'')

                    if(salary_from.includes('.00')){
                    salary_from=salary_from.replace(".00","")
                    }
                    if(salary_from.includes('.0') && !salary_from.includes('.00')){
                    console.log("paso")
                    salary_from= salary_from.replace(".0","") 
                    salary_from= salary_from.substring(0, salary_from.length - 1);
                    }

                    console.log()
                    if(salary_from!='' && !parseFloat(salary_from).toString().includes(NaN)){
                    salary_from='$' + parseFloat(parseInt(salary_from), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();  
                    }else{
                    salary_from='';
                    }
                    return salary_from;
                    }

                    function showProcessingForm(btn_id){		
                    $("#"+btn_id).val( 'Processing .....' );
                    $("#"+btn_id).attr('disabled','disabled');		
                    }



                    // Obtener todos los inputs de la página
                    let inputs = document.querySelectorAll('.pascalCase');

                    // Iterar sobre los inputs y agregar el evento onblur
                    for (let i = 0; i < inputs.length; i++) {
                    let input = inputs[i];
                    input.addEventListener('blur', function() {
                    pascalCase(input);
                    });
                    }

                    // Función para convertir a pascal case
                    function pascalCase(input) {
                    let inputValue = input.value.toLowerCase();
                    let words = inputValue.split(" ");
                    let capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
                    let pascalCase = capitalizedWords.join(" ");
                    input.value = pascalCase;
                    }


                    // Obtener los botones y los elementos de texto
                    const decreaseButton = document.getElementById('decrease-font-size');
                    const resetButton = document.getElementById('reset-font-size');
                    const increaseButton = document.getElementById('increase-font-size');
                    const elements = document.querySelectorAll('p, span, h1, h2, h3, h4, h5, h6, a, label, button  ');

                    // Establecer el tamaño de fuente base
                    let baseFontSize = 16;

                    // Función para aplicar el tamaño de fuente a los elementos
                    function applyFontSize(fontSize) {
                    elements.forEach(element => {
                    element.style.fontSize = `${fontSize}px`;
                    });
                    }

                    // Manejadores de eventos para los botones
                    decreaseButton.addEventListener('click', () => {
                    baseFontSize -= 2;
                    applyFontSize(baseFontSize);
                    });

                    resetButton.addEventListener('click', () => {
                    baseFontSize = 16;
                    applyFontSize(baseFontSize);
                    });

                    increaseButton.addEventListener('click', () => {
                    baseFontSize += 2;
                    applyFontSize(baseFontSize);
                    });



                    function toggleDarkMode() {

                                const body = document.body;
                                const elements = document.querySelectorAll('div, li, table, .containers');
                                const textos = document.querySelectorAll('a, p, h1, h2, h3, h4, h5, h6, span');
                                
                                const isDarkMode = body.classList.toggle('dark-mode');

                                elements.forEach((element) => {
                                    if (!element.classList.contains('logo')) {
                                    element.classList.toggle('dark-mode');
                                    }
                                });

                                textos.forEach((element) => {
                                    if (!element.classList.contains('logo')) {
                                    element.classList.toggle('dark-mode');
                                    }
                                });
                                
                        const expires = new Date(Date.now() + 24 * 60 * 60 * 1000).toUTCString();
                        const cookieValue = isDarkMode ? 'dm' : ''; 
                        document.cookie = 'ck=' + cookieValue + '; expires=' + expires + '; path=/';

                    }


                        function getCookie(name) {
                        const cookies = document.cookie.split(';');
                        for (let i = 0; i < cookies.length; i++) {
                        const cookie = cookies[i].trim();
                        if (cookie.startsWith(name + '=')) {
                        return cookie.substring(name.length + 1);
                        }
                        }
                        return '';
                        }

                </script>
</body>

</html>
