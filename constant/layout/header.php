<?php

include('./constant/check.php');
require_once('./constant/connect.php');

// get all the medicines that are expired by date.

$sql = "SELECT * FROM product";
$result = $connect->query($sql);

function checkIfProductIsExpired($product){
    $d1 = date('Y-m-d');
    return $product['expdate'] < $d1;
}

function getArrayOfProducts($mysqlResultSet){
    $productArray = [];
    $i = 0;
    foreach ($mysqlResultSet as $row) {
        $productArray[$i] = $row;
        $i++;
    }
    return $productArray;
}

$expiredProducts = array_filter(getArrayOfProducts($result), "checkIfProductIsExpired");

?>

<div id="main-wrapper">

    <div class="header">
        <marquee class="d-lg-none d-block">
            <div class="ml-lg-5 pl-lg-5 ">

                <b id="ti" class="ml-lg-5 pl-lg-5"></b>


            </div>
        </marquee>
        <nav class="navbar top-navbar navbar-expand-md navbar-light">

            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">


                    <b><img src="./assets/uploadImage/Logo/logo.png" style="width: 30%;" alt="homepage" class="dark-logo" style="width:100%;height:auto;" /></b>

                </a>
            </div>

            <div class="navbar-collapse">

                <ul class="navbar-nav  mt-md-0">

                    <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                    <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>

                </ul>

                <ul class="navbar-nav my-lg-0 ml-auto">
                    <li style="width: 25px; display: flex; position: relative" id="<?php if(count($expiredProducts) > 0){ echo "myBtn"; } ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7E7E7E" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span style="position: absolute;
right: 0;
background: red;
padding: 2px;
color: white;
border-radius: 10px;">
                        <?php
                        echo count($expiredProducts);
                        ?>
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img src="./assets/uploadImage/Profile/usuario-admin.png" alt="user" class="profile-pic" /></a>
                        <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                            <ul class="dropdown-user">
                                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] == 1) { ?>
                                <?php } ?>

                                <li><a href="./constant/logout.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </nav>

        <!-- Trigger/Open The Modal -->

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="text-primary">Expired products</h3>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th style="width:10%;">Foto</th>

                            <th>Nombre Medicina</th>
                            <th>Cant Por Unidad</th>
                            <th>Cantidad</th>
                            <th>Fabricante</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($expiredProducts as $row) {

                        $sql = "SELECT * from brands where brand_id='" . $row['brand_id'] . "'";
                        $result1 = $connect->query($sql);
                        $row1 = $result1->fetch_assoc();


                        $sql = "SELECT * from categories where categories_id='" . $row['categories_id'] . "'";
                        $result2 = $connect->query($sql);
                        $row2 = $result2->fetch_assoc();


                        ?>
                        <tr>


                            <td class="text-center"><?php echo $row['product_id'] ?></td>
                            <td><img src="assets/myimages/<?php echo $row['product_image']; ?>" style="width: 80px; height: 80px;"></td>


                            <?php $d1 = date('Y-m-d');
                            //echo $d1.$row['expdate'];exit;
                            if ($row['expdate'] >= $d1) { //echo "abc1";
                                ?>

                                <td> <label class="label label-success"><?php echo $row['product_name']; ?></label></td>
                            <?php  }
                            if ($row['expdate'] < $d1) { //echo "abc";
                                ?>
                                <td><label class="label label-danger"><?php echo $row['product_name']; ?></label></td>

                                <?php
                            }
                            ?>
                            <td><?php echo $row['rate'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td><?php echo $row1['brand_name'] ?></td>
                            <td><?php echo $row2['categories_name'] ?></td>
                            <td><?php if ($row['active'] == 1) {

                                    $activeBrands = "<label class='label label-success' ><h4>Disponible</h4></label>";
                                    echo $activeBrands;
                                } else {
                                    $activeBrands = "<label class='label label-danger'><h4>No disponible</h4></label>";
                                    echo $activeBrands;
                                } ?></td>
                            <td>

                                <a href="editproduct.php?id=<?php echo $row['product_id'] ?>"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></button></a>



                                <a href="php_action/removeProduct.php?id=<?php echo $row['product_id'] ?>"><button type="button" class="btn btn-xs btn-danger" onclick="return confirm('Deseas eliminar este registro?')"><i class="fa fa-trash"></i></button></a>


                            </td>
                        </tr>

                        </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>

            </div>

        </div>

    </div>
    <script language="javascript">
        var today = new Date();
        document.getElementById('ti').innerHTML = today;

        var today = new Date();
        document.getElementById('time').innerHTML = today;
    </script>


    <script>

        if (window.localStorage.showModalExpired === undefined){
            window.localStorage.showModalExpired = 1;
        }

        // Get the modal
        var modal = document.getElementById("myModal");

        <?php
            if (count($expiredProducts)>0){
                echo "
                if(window.localStorage.showModalExpired !== null && window.localStorage.showModalExpired == 1){
                    modal.style.display = \"block\";
                    			window.addEventListener('load', () => {
				// noinspection JSUnresolvedVariable
				let audioCtx = new (window.AudioContext || window.webkitAudioContext)();
				let xhr = new XMLHttpRequest();
				xhr.open('GET', 'bells-1.wav');
				xhr.responseType = 'arraybuffer';
				xhr.addEventListener('load', () => {
					let playsound = (audioBuffer) => {
						let source = audioCtx.createBufferSource();
						source.buffer = audioBuffer;
						source.connect(audioCtx.destination);
						source.loop = false;
						source.start();
					};

					audioCtx.decodeAudioData(xhr.response).then(playsound);
				});
				xhr.send();
			});
                }
                ";
            }

        ?>

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            window.localStorage.showModalExpired = 1;
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            if (confirm("¿Desea que no se este recordando mas sobre los productos vencidos?")) {
                window.localStorage.showModalExpired = 0;
            }
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                if (confirm("¿Desea que no se este recordando mas sobre los productos vencidos?")) {
                    window.localStorage.showModalExpired = 0;
                }
                modal.style.display = "none";
            }
        }
    </script>


    <style>
        body {font-family: Arial, Helvetica, sans-serif;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>