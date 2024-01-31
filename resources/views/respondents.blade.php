<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="https://flamingoinsights.com/assets/logo.png">
</head>
<title>Flamingo Insights</title>
<style>
    #circle {
        position: relative;
        margin-top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
    }

    .loader {
        width: calc(100% - 0px);
        height: calc(100% - 0px);
        border: 8px solid #28c8d3;
        border-top: 8px solid #fff;
        border-radius: 50%;
        animation: rotate 5s linear infinite;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body style="overflow: hidden;">
    <div class="container-fluid" style="background-image: url(/assets/img/redirect/bg.jpg);">
        <div class="row d-flex justify-content-around align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="{{assetassets/img/redirect/bg.jpg" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <div class="text-white text-center">
                    <div id="circle">
                        <div class="loader">
                            <div class="loader">
                                <div class="loader">
                                    <div class="loader">
                                        <div class="loader">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="mb-4 text-white" v-if="data.success">Redirecting...</h2>
                    <h1 class="mb-4 text-white">{{ $data['title'] }}</h1>
                    <p class="mb-0 fs-4">{{ $data['message'] }}</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
