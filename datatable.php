<?php
if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once 'classes/config.php';
require_once 'classes/Auth.class.php';
require_once "classes/safemysql.php";
$db = new SafeMySQL($config);
if (User::isAuthorized()):

if(isset($_GET["view"])):
    $view = $_GET["view"];
    switch ($view) {
        case 'employes':
            require_once 'classes/models/employe.php';
            require_once 'classes/models/departments.php';
            $dep = new DepartmentModel($db);
            $employers = new EmployeModel($db);
            $departments = $dep->getDepartments($_SESSION["user"]["OrgID"]);
            $departmentID = null;
            if(isset($_POST["departmentsFilter"])){
                $departmentID = $_POST["departmentsFilter"];
            }
            if(isset($_POST["employersSearch"])){
                $employersList =  $employers->getEmployeByOrgID($_SESSION["user"]["OrgID"],$departmentID);
            }
            else{
                $employersList = $employers->getEmployeByOrgID($_SESSION["user"]["OrgID"],$departmentID);
            }
            $pageTitle = "Сотрудники";
            $dataTableRows = array("№","ФИО", "Отдел", "Должность");
            $dataRows = $employersList;
            break;
        case 'departments':
            require_once 'classes/models/departments.php';
            $dep = new DepartmentModel($db);
            $departments = $dep->getDepartments($_SESSION["user"]["OrgID"]);
            $pageTitle = "Отделы";
            $dataTableRows = array("№","Название", "Всего сотрудников");
            break;
        case 'items':
            $pageTitle = "Учет";
            $dataTableRows = array("№","Наименование", "Тип", "Отдел", "Сотрудник");
            break;
        case 'itemtypes':
            $pageTitle = "Предметы учета";
            $dataTableRows = array("№","Наименование");
            break;
        default:
            # code...
            break;
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="css/vendor/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="css/vendor/datatables.responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="css/vendor/select2.min.css" />
    <link rel="stylesheet" href="css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/vendor/glide.core.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="css/styles.css" />
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php include_once "navbartop.php"; ?>
    <?php include_once "navbarleft.php"; ?>

    <main>
    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo  $pageTitle ; ?></h1>
                    <div class="top-right-button-container">
                        <button type="button" class="btn btn-primary btn-lg top-right-button mr-1" data-toggle="modal"
                            data-target="#exampleModalRight">Добавить</button>
                        <div class="btn-group">
                            <div class="btn btn-primary btn-lg pl-4 pr-0 check-button">
                                <label class="custom-control custom-checkbox mb-0 d-inline-block">
                                    <input type="checkbox" class="custom-control-input" id="checkAllDataTables">
                                    <span class="custom-control-label">&nbsp;</span>
                                </label>
                            </div>
                            <button type="button" class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Удалить</a>
                            </div>
                        </div>
                    </div>

                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Library</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                    <div class="mb-2">
                        <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                            role="button" aria-expanded="true" aria-controls="displayOptions">
                            Опции
                            <i class="simple-icon-arrow-down align-middle"></i>
                        </a>
                        <div class="collapse dont-collapse-sm" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input class="form-control" placeholder="Быстрый поиск..." id="searchDatatable">
                                </div>
                            </div>
                            <div class="d-block d-md-inline-block">
                                <form action="" method="post" name="departmentFilter" id="departmentFilter">
                                    <div class="d-inline-block float-md-left mr-1 mb-1 align-top">
                                        <select class="data-table-filter" name="departmentsFilter" id="departmentsFilter">
                                            <option value=0>Выберите отдел</option>
                                            <?php
                                            for ($i=0; $i <count($departments); $i++) { ?>
                                                <option <?php if($departmentID==$departments[$i]["id"]){echo "selected";} ?> value=<?php echo $departments[$i]["id"]; ?>> <?php echo $departments[$i]["name"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </form>  
                            </div>
                            <div class="d-block d-md-inline-block">
                                <div class="d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input class="data-table-filter" placeholder="Полный поиск..." id="searchDatatableFull">
                                </div>
                            </div>
                            <div class="float-md-right dropdown-as-select" id="pageCountDatatable">
                                <span class="text-muted text-small">Показать </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    10
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">5</a>
                                    <a class="dropdown-item active" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-4 data-table-rows data-tables-hide-filter">
                    <table id="datatableRows" class="data-table responsive nowrap"
                        data-order="[[ 0, &quot;asc&quot; ]]">
                        <thead>
                            <tr>
                                <?php
                                for ($i=0;  $i < count($dataTableRows); $i++) { 
                                    echo "<th>".$dataTableRows[$i]."</th>";
                                }
                                ?>
                                <th class="empty">Отметить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($j=0; $j < count($dataRows); $j++) { 
                                   echo "<tr><td><p class='text-muted'>".($j+1)."</td>
                                        <td><p class='list-item-heading'>".$dataRows[$j]["sorname"]." ".$dataRows[$j]["name"]." ".$dataRows[$j]["thirdname"]."</td>
                                        <td><p class='text-muted'>".$dataRows[$j]["dname"]."</td>
                                        <td><p class='text-muted'>".$dataRows[$j]["position"]."</td>";
                                        
                                ?>
                                <td>
                                    <label class="custom-control custom-checkbox mb-1 align-self-center data-table-rows-check">
                                        <input type="checkbox" class="custom-control-input" id="checkboxAction<?php echo $j; ?>">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                </td>
                            <?php  
                                echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <!-- start right modal form -->
    <div class="modal fade modal-right" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalForm">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary"
                        data-dismiss="modal">Выход</button>
                    <button type="button" class="btn btn-primary" id="formSubmit">Отправить</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end right modal form -->
    <footer class="page-footer">
        <div class="footer-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <p class="mb-0 text-muted">Copyrights OAO RZD <?php echo date('Y'); ?></p>
                    </div>
                    <div class="col-sm-6 d-none d-sm-block">
                        <ul class="breadcrumb pt-0 pr-0 float-right">
                            <li class="breadcrumb-item mb-0">
                                <a href="#" class="btn-link">Справка</a>
                            </li>
                            <li class="breadcrumb-item mb-0">
                                <a href="#" class="btn-link">Помощь</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/vendor/Chart.bundle.min.js"></script>
    <script src="js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="js/vendor/moment.min.js"></script>
    <script src="js/vendor/fullcalendar.min.js"></script>
    <script src="js/vendor/datatables.min.js"></script>
    <script src="js/vendor/perfect-scrollbar.min.js"></script>
    <script src="js/vendor/glide.min.js"></script>
    <script src="js/vendor/progressbar.min.js"></script>
    <script src="js/vendor/jquery.barrating.min.js"></script>
    <script src="js/vendor/select2.full.js"></script>
    <script src="js/vendor/nouislider.min.js"></script>
    <script src="js/vendor/bootstrap-datepicker.js"></script>
    <script src="js/vendor/Sortable.js"></script>
    <script src="js/vendor/mousetrap.min.js"></script>
    <script src="js/vendor/bootstrap-notify.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/datatables.js"></script>
</body>

</html>
<?php 
    else:
        header("Location:index.php");
        die();
    endif;
else:
    header("Location:index.php");
    die();
endif;
?>