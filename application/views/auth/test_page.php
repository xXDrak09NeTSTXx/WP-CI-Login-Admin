<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- my css -->
    <style>
        section {
            min-height: 420px;
        }
    </style>
    <title><?= $tittle; ?></title>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg  navbar-light" style="background-color: #00FF00;">
        <div class=" container">
            <a class="navbar-brand" href="#">Test</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="#">Features</a>
                    <a class="nav-item nav-link" href="#">Pricing</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- jumbotron -->
    <section id="jumbotron" class="my-jumbotron">
        <div class="jumbotron jumbotron-fluid mb-5" style="background-color: #00CCCC">
            <div class="container text-center">
                <img src=" <?= base_url('asset/img/2.jpg'); ?>" width="25%" class=" img-thumbnail mt-5 rounded-circle">
                <h2 class="display-4">Mustofa</h2>
                <p class="lead">My Name Mustofa Now student</p>
            </div>
        </div>
    </section>
    <!-- end jumbotron -->


    <!-- about  -->
    <section id="about" class="about">
        <div class="container mt-5 mb-5">
            <div class="row mb-5 pb-5">
                <div class="col-lg text-center">
                    <h1>About</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class=" col-md-5 text-center">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Illo alias deleniti earum. Vitae eum deleniti id at eaque,
                        ex iste facilis quos incidunt reprehenderit nulla eveniet
                        saepe! Unde, sunt aliquid?
                    </p>
                </div>
                <div class="col-md-5 text-center">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Illo alias deleniti earum. Vitae eum deleniti id at eaque,
                        ex iste facilis quos incidunt reprehenderit nulla eveniet
                        saepe! Unde, sunt aliquid?
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end about -->

    <!-- Photopolio -->
    <section id="photopolio" class="photopolio bg-light pb-5">
        <div class="contair mt-5">
            <div class="row mb-5 pt-5">
                <div class="col text-center">
                    <h2>Photopolio</h2>
                </div>
            </div>
            <div class="row justify-content-center mb-5">
                <div class="col-sm-3">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class=" card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi eius fugiat beatae. Nihil suscipit excepturi quaerat minus voluptatem tenetur. Aut illo consectetur molestias? Sit perferendis iste incidunt! Dolorum, quibusdam culpa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos cumque temporibus illum id, eum aut ipsam veritatis fugit excepturi amet mollitia ipsa facilis iusto quae, impedit incidunt quibusdam quas facere.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi reprehenderit consequuntur cumque exercitationem perspiciatis! Ipsa, ducimus, voluptates exercitationem sit tenetur ullam recusandae perspiciatis voluptatem itaque ipsam, incidunt amet laborum. Temporibus.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-5">
                <div class="col-sm-3">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Deserunt, recusandae voluptatem corporis maxime id dolorum eaque harum iste maiores culpa saepe labore itaque, laboriosam, quae fugit in nam voluptate nihil?</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quod ut, hic doloremque vel, culpa placeat sunt voluptate nisi tempora nulla molestiae est recusandae quaerat numquam repellendus, ad ipsum libero consectetur?</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="card">
                        <img src=" <?= base_url('asset/img/2.jpg'); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam velit nesciunt quas ullam natus aut non quis nisi incidunt commodi praesentium quisquam voluptatibus asperiores error itaque, minima distinctio quasi. Maiores.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end Photopolio -->

    <!-- contact -->
    <section id="section" class="section mb-5 pb-5">
        <div class="container">
            <div class="row pt-5 mb-5">
                <div class="col text-center">
                    <h2>Contact Us</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card text-white bg-primary mb-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Contact Us</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure necessitatibus eveniet incidunt obcaecati laboriosam laudantium sed quasi at esse amet aut a laborum ipsam repellendus, unde magnam dolorum exercitationem ad.</p>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <h1>Location</h1>
                    </li>
                    <li class="list-group-item">My Office</li>
                    <li class="list-group-item">jl.Otitsta raya</li>
                    <li class="list-group-item">West Java, Indonesia</li>
                </ul>
            </div>
            <div class="col-lg-5">
                <form class="mt-5">
                    <div class="form-group">
                        <label for="nama">Name</label>
                        <input type="text" class="form-control" id="nama" placeholder="For name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="For email">
                    </div>
                    <div class="form-group">
                        <label for="Phone">Phone</label>
                        <input type="text" class="form-control" id="Phone" placeholder="For name">
                    </div>
                    <div class="form-group">
                        <label for="pesan">Massage</label>
                        <textarea name="pesan" id="pesan" class="form-control"></textarea>
                    </div>
                </form>
                <button type="button" class="btn btn-primary">Send</button>
            </div>
        </div>
    </section>
    <!-- end contact -->

    <!-- footer -->
    <footer class="bg-dark text-white-50">
        <div class="container">
            <div class="row pt-3">
                <div class="col text-center">
                    <p>Copyright 2019</p>
                </div>
            </div>
        </div>

    </footer>
    <!-- end footer -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html> 