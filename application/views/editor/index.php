<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporting Engine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>">
    <link href="<?= base_url('assets/') ?>fontawesome/css/fontawesome.css" rel="stylesheet" />
    <link href="<?= base_url('assets/') ?>fontawesome/css/brands.css" rel="stylesheet" />
    <link href="<?= base_url('assets/') ?>fontawesome/css/solid.css" rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
        integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        />
    <style type="text/css" media="screen">
        .popover{
            max-width:430px;
        }
        .editor { 
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        .aro {
            display:none;
        }

        .horizontal .right {
            display:block !important;
        }

        .vertical .down {
            display:block !important;
        }

        .flip-y {
            -moz-transform: scale(1, -1);
            -webkit-transform: scale(1, -1);
            -o-transform: scale(1, -1);
            -ms-transform: scale(1, -1);
            transform: scale(1, -1);
        }
        .query-result {
            white-space: pre-wrap;
            font-family: monospace;
            padding: 10px;
            overflow: auto;
            font-size: 10px
        }
        .query-result .key {
            color: brown;
        }
        .query-result .string {
            color: green;
        }
        .query-result .number {
            color: blue;
        }
        .query-result .boolean {
            color: purple;
        }
        .query-result .null {
            color: red;
        }
    </style>
  </head>
  
  <body class="overflow-hidden">
    <!-- Section: Design Block -->
    <section class="background-radial-gradient position-relative containers" style="height:100vh; width:100vw; overflow-x:scroll">
        <div class="px-4 py-5 px-md-5 position-relative" style="width:auto; min-width:100%">
            <div id="connector" class="position-absolute" style="z-index:100; width:300px; height:5px; top:0; left:0;">
                <div style="width:50%; height:50%; top:0; left:0; border-radius: 0 1000px 0 0; box-shadow: inset -1px 0px 0px 0px white, inset 0px 1px 0px 0px white;;" class="position-absolute"></div>
                <div style="width:50%; height:50%; bottom:0; right:0; border-radius: 0 0 0 1000px; box-shadow: -1px 0px 0px 0px white, 0px 1px 0px 0px white;" class="position-absolute"></div>
            </div>
            <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
            <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
            <div style="gap:10px" class="d-flex gx-lg-5 align-items-start justify-content-left mb-5">

                <div>
                    <div class="card bg-glass border" style="width:300px">
                        <div class="card-body px-2 py-2">
                            <h5 class="mb-0">Connection</h5>
                            <hr>
                            <?php foreach($databases as $db): ?>
                            <div class="rounded border d-flex align-items-center justify-content-between mb-2 databases-<?= $db->id ?>">
                                <div class="p-2 d-flex flex-column">
                                    <strong><?= $db->database_name ?></strong>
                                    <small><em><?= $db->hostname ?></em></small>
                                </div>
                                <div class="d-flex" style="gap:10px">
                                    <a class="link-secondary" modtrig="databases~~<?= $db->id ?>" href="#"><i class="fa-solid fa-wrench fa-xs"></i></a>
                                    <a class="link-danger" style="margin-right:10px" moddel="Conection '<?= $db->database_name ?>'//databases//<?= $db->id ?>" href="#"><i class="fa-solid fa-trash-can fa-xs"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="rounded border d-flex align-items-center justify-content-center p-1 mb-2">
                                <button class="btn" style="width:100%" modtrig="databases" href="#"><i class="fa-solid fa-plus fa-xl"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card bg-glass border" style="width:300px">
                        <div class="card-body px-2 py-2">
                            <h5 class="mb-0">Query Builder</h5>
                            <hr>
                            <?php foreach($query as $que): ?>
                            <div class="rounded border d-flex align-items-center justify-content-between mb-2 query-<?= $que->id ?>">
                                <div class="p-2 d-flex flex-column">
                                    <strong><?= $que->name ?></strong>
                                    <small><em><?= $que->db_name ?></em></small>
                                </div>
                                <div class="d-flex" style="gap:10px">
                                    <a class="link-secondary" modtrig="query~~<?= $que->id ?>" href="#"><i class="fa-solid fa-wrench fa-xs"></i></a>
                                    <a class="link-danger" style="margin-right:10px" moddel="Query '<?= $que->name ?>'//query//<?= $que->id ?>" href="#"><i class="fa-solid fa-trash-can fa-xs"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="rounded border d-flex align-items-center justify-content-center p-1 mb-2">
                                <button class="btn" style="width:100%" modtrig="query" href="#"><i class="fa-solid fa-plus fa-xl"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card bg-glass border" style="width:300px">
                        <div class="card-body px-2 py-2">
                            <h5 class="mb-0">Array Builder</h5>
                            <hr>
                            <?php foreach($array as $arr): ?>
                            <div class="rounded border d-flex align-items-center justify-content-between mb-2 array-<?= $arr->id ?>">
                                <div class="p-2 d-flex flex-column">
                                    <strong><?= $arr->name ?></strong>
                                </div>
                                <div class="d-flex" style="gap:10px">
                                    <a class="link-secondary" modtrig="array~~<?= $arr->id ?>" href="#"><i class="fa-solid fa-wrench fa-xs"></i></a>
                                    <a class="link-danger" style="margin-right:10px" moddel="Array '<?= $arr->name ?>'//array//<?= $arr->id ?>" href="#"><i class="fa-solid fa-trash-can fa-xs"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="rounded border d-flex align-items-center justify-content-center p-1 mb-2">
                                <button class="btn" style="width:100%" modtrig="array" href="#"><i class="fa-solid fa-plus fa-xl"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card bg-glass border" style="width:300px">
                        <div class="card-body px-2 py-2">
                            <h5 class="mb-0">Template Manager</h5>
                            <hr>
                            <?php foreach($template as $temp): ?>
                            <div class="rounded border d-flex align-items-center justify-content-between mb-2 template-<?= $temp->id ?>">
                                <div class="p-2 d-flex flex-column">
                                    <strong><?= $temp->name ?></strong>
                                    <small><em><?= $temp->file ?></em></small>
                                </div>
                                <div class="d-flex" style="gap:10px">
                                    <a class="link-secondary" modtrig="template~~<?= $temp->id ?>" href="#"><i class="fa-solid fa-wrench fa-xs"></i></a>
                                    <a class="link-danger" style="margin-right:10px" moddel="Template '<?= $temp->name ?>'//template//<?= $temp->id ?>" href="#"><i class="fa-solid fa-trash-can fa-xs"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="rounded border d-flex align-items-center justify-content-center p-1 mb-2">
                                <button class="btn" style="width:100%" modtrig="template" href="#"><i class="fa-solid fa-plus fa-xl"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card bg-glass border" style="width:300px">
                        <div class="card-body px-2 py-2">
                            <h5 class="mb-0">Reporting</h5>
                            <hr>
                            <?php foreach($report as $repo): ?>
                            <div data-template="template-<?= $repo->template_id ?>" data-id="<?= $repo->id ?>" style="cursor: pointer;" class="rounded border report-card d-flex align-items-center justify-content-between mb-2 report-<?= $repo->id ?>">
                                <div class="p-2 d-flex flex-column">
                                    <strong><?= $repo->name ?></strong>
                                    <small><em><?= $repo->template_name ?></em></small>
                                </div>
                                <div class="d-flex" style="gap:10px">
                                    <a class="link-secondary" modtrig="report~~<?= $repo->id ?>" href="#"><i class="fa-solid fa-wrench fa-xs"></i></a>
                                    <a class="link-danger" style="margin-right:10px" moddel="Report '<?= $repo->name ?>'//report//<?= $repo->id ?>" href="#"><i class="fa-solid fa-trash-can fa-xs"></i></a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <div class="rounded border d-flex align-items-center justify-content-center p-1 mb-2">
                                <button class="btn" style="width:100%" modtrig="report" href="#"><i class="fa-solid fa-plus fa-xl"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-5">
                    <div class="card bg-glass border" style="width:90vw; height:90vh">
                        <div class="card-body px-2 py-2 d-flex flex-column" style="height:100%">
                            <div>
                                <h5 class="mb-0">Editor</h5>
                                <hr>
                            </div>
                            <div style="flex-grow:4; overflow:hidden" id="editor-wraper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!-- modal -->

    <div class="modal fade bg-glass" id="modallg" tabindex="-1" aria-labelledby="modallgLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-glass">
          <div class="modal-body" id="modallg-content">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade bg-glass" id="modaldelete" tabindex="-1" aria-labelledby="modaldeleteLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content bg-glass">
          <div class="modal-body" id="modaldelete-content">
            <h5>
              Confirm delete <span id="deleted-item"></span>?
            </h5>
          </div>
          <div class="modal-footer">
            <a type="button" href="" id="delete-btn" class="btn btn-danger">Delete</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div id="dummy" class="d-none">
        <div style="width:400px">

            <form action="<?= base_url('index.php/process/insert/itterate') ?>" method="post">
                <div class="mb-2">
                    <label class="form-text" for="arrayy">Array</label>
                    <select class="form-select array-selector" name="array_id" id="arrayy" aria-label="Default select example">
                        <option value="" selected>none</option>
                        <?php foreach($array as $arr): ?>
                            <option value="<?= $arr->id ?>"><?= $arr->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-text" for="direction">Direction</label>
                    <select class="form-select direction-selector" name="direction" id="direction" aria-label="Default select example">
                        <option value="" selected>none</option>
                        <option value="1">horizontal</option>
                        <option value="2">vertical</option>
                    </select>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-text" for="limit">Limit</label>
                        <input type="number" value="" class="form-control form-report-limit" name="limit">
                    </div>
                    <div class="col">
                        <label class="form-text" for="offset">Offset</label>
                        <input type="number" value="" class="form-control form-report-offset" name="offset">
                    </div>
                </div>

                <input type="hidden" class="form-report-id" name="report_id" value="">
                <input type="hidden" class="form-report-sheet" name="sheet" value="">
                <input type="hidden" class="form-report-row" name="row" value="">
                <input type="hidden" class="form-report-col" name="col" value="">
                
                <div class="collapser">
                    <button class="btn btn-primary" type="button" onclick="collapsing(this)">
                        Button with data-bs-target
                    </button>
                    <div class="collapse collapse-container">
                        <div class="card p-2">
                            <div class="d-flex my-2 justify-content-between">
                                <div class="p-0">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-font fa-2xs"></i><i class="fa-solid fa-font"></i>
                                        <input type="number" value="" class="form-control form-report-font-size mx-2" style="width:70px" name="style[font-size]">
                                    </div>
                                </div>
                                <span style="border-left:1px solid grey"></span>
                                <div class="p-0">
                                    <div class="collapser position-relative d-flex justify-content-center">
                                        <button class="btn btn-dark rounded-pill mx-2 btn-collapser" type="button" onclick="collapsing(this)"><i class="fa-solid fa-palette"></i></button>
                                        <div class="collapse collapse-container collapse-horizontal position-absolute" style="top: 4px; left: 65px">
                                            <div class="card rounded-pill p-1">
                                                <div class="d-flex flex-row">
                                                    <button style-color="" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:black; color:white; font-size:10px">&#x2715;</button>
                                                    <button style-color="FF000000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:black"></button>
                                                    <button style-color="FFFFFFFF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:white"></button>
                                                    <button style-color="FFFF0000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:red"></button>
                                                    <button style-color="FF800000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkred"></button>
                                                    <button style-color="FF00FF00" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:green"></button>
                                                    <button style-color="FF008000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkgreen"></button>
                                                    <button style-color="FF0000FF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:blue"></button>
                                                    <button style-color="FF000080" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkblue"></button>
                                                    <button style-color="FFFFFF00" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:yellow"></button>
                                                    <button style-color="FF808000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:yellowgreen"></button>
                                                    <button style-color="FF00FFFF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:cyan"></button>
                                                    <button style-color="FFFF00FF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:magenta"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span style="border-left:1px solid grey"></span>
                                <div class="px-2 d-flex justify-content-between align-items-center">
                                    <button type="button" style-type="bold" class="btn btn-light"><i class="fa-solid fa-bold"></i></button>
                                    <button type="button" style-type="underline" class="btn btn-light"><i class="fa-solid fa-underline"></i></button>
                                    <button type="button" style-type="italic" class="btn btn-light"><i class="fa-solid fa-italic"></i></button>
                                    <button type="button" style-type="strikethrough" class="btn btn-light"><i class="fa-solid fa-strikethrough"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="px-2 d-flex justify-content-between align-items-stretch">
                                    <button type="button" horizontal-align="left" class="btn btn-light"><i class="fa-solid fa-align-left"></i></button>
                                    <button type="button" horizontal-align="center" class="btn btn-light"><i class="fa-solid fa-align-center"></i></button>
                                    <button type="button" horizontal-align="right" class="btn btn-light"><i class="fa-solid fa-align-right"></i></button>
                                </div>
                                <span style="border-left:1px solid grey"></span>
                                <div class="px-2 d-flex justify-content-between align-items-stretch">
                                    <button type="button" style="width:30px" vertical-align="top" class="p-0 btn btn-light position-relative"><i style="left:10px; top: 12px" class="position-absolute fa-solid fa-pause fa-rotate-90 fa-2xs"></i></button>
                                    <button type="button" style="width:30px" vertical-align="center" class="p-0 btn btn-light position-relative"><i style="left:10px; top: 22px" class="position-absolute fa-solid fa-pause fa-rotate-90 fa-2xs"></i></button>
                                    <button type="button" style="width:30px" vertical-align="bottom" class="p-0 btn btn-light position-relative"><i style="left:10px; bottom: 12px" class="position-absolute fa-solid fa-pause fa-rotate-90 fa-2xs"></i></button>
                                </div>
                                <span style="border-left:1px solid grey"></span>
                                <div class="p-1 d-flex justify-content-between align-items-center col-4">
                                    <button class="btn btn-outline-secondary p-0" borders="left" type="button" style="height:30px; width:6px; left:30px"></button>
                                    <div class="d-flex flex-column justify-content-between align-items-center">
                                        <button class="btn btn-outline-secondary p-0" borders="top" type="button" style="height:6px; width:80%; top:10px"></button>
                                        <div class="collapser position-relative d-flex justify-content-center">
                                            <button class="btn border btn-collapser" type="button" onclick="collapsing(this)" style="width:110px; height:30px"></button>
                                            <div class="collapse collapse-container collapse-horizontal position-absolute" style="top: 4px; left: 65px">
                                                <div class="card rounded-pill p-1">
                                                    <div class="d-flex flex-row">
                                                        <button style-cell="" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:white; font-size:10px">&#x2715;</button>
                                                        <button style-cell="FF000000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:black"></button>
                                                        <button style-cell="FFFFFFFF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:white"></button>
                                                        <button style-cell="FFFF0000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:red"></button>
                                                        <button style-cell="FF800000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkred"></button>
                                                        <button style-cell="FF00FF00" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:green"></button>
                                                        <button style-cell="FF008000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkgreen"></button>
                                                        <button style-cell="FF0000FF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:blue"></button>
                                                        <button style-cell="FF000080" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:darkblue"></button>
                                                        <button style-cell="FFFFFF00" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:yellow"></button>
                                                        <button style-cell="FF808000" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:yellowgreen"></button>
                                                        <button style-cell="FF00FFFF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:cyan"></button>
                                                        <button style-cell="FFFF00FF" type="button" class="btn btn-sm border rounded-pill" style="width:20px; height:20px; padding:0; background-color:magenta"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-secondary p-0" borders="bottom" type="button" style="height:6px; width:80%; bottom:10px"></button>
                                    </div>
                                    <button class="btn btn-outline-secondary p-0" borders="right" type="button" style="height:30px; width:6px; right:30px"></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-none">
                            <input type="hidden" value="" name="style[color]">
                            <input type="hidden" value="" name="style[bold]">
                            <input type="hidden" value="" name="style[underline]">
                            <input type="hidden" value="" name="style[italic]">
                            <input type="hidden" value="" name="style[strikethrough]">
                            <input type="hidden" value="" name="style[horizontal]">
                            <input type="hidden" value="" name="style[vertical]">
                            <input type="hidden" value="" name="style[top]">
                            <input type="hidden" value="" name="style[bottom]">
                            <input type="hidden" value="" name="style[right]">
                            <input type="hidden" value="" name="style[left]">
                            <input type="hidden" value="" name="style[cell]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn save-form btn-primary"> save</button>
                <button type="button" class="btn btn-secondary close-form"> close</button>
            </form>
        </div>
    </div>
    <div id="loader" class="d-none"></div>
    
    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/ace/') ?>ace.js" type="text/javascript" charset="utf-8"></script>
    <!-- Section: Design Block -->

    <script>
        function collapsing(ini){
            target = $(ini).closest('.collapser').find('.collapse-container')[0]
            $(target).collapse('toggle');
        }
        $(document).ready(function(){
            editor = null;
            let baseUrl = "<?= base_url() ?>"
            $(document).on('submit', 'form', function(e) {
                e.preventDefault();
                let form = $(this)[0]; // Use the DOM element
                let formData = new FormData(form); // Create FormData object from the form

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false, // Prevent jQuery from automatically setting the Content-Type header
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    success: function(res) {
                        if (res != 'done') {
                            let msg = JSON.parse(res).reason[0];
                            $(form).find(".msg").html(msg);
                            $(form).find(".alerting").collapse('show');
                        } else {
                            window.location.reload();
                        }
                    }
                });
            });
            let activeEditor = null;
            $(".report-card").click(function(){
                $(".report-card").removeClass('bg-glass')
                $(this).addClass('bg-glass')
                getPoint($(this))

                let id = $(this).attr('data-id')
                if(id != activeEditor){
                    activeEditor = id
                    let url = baseUrl + "index.php/dashboard/modal/editor~~" + id
                    $("#editor-wraper").load(url);
                }
            });

            
            $(document).on("click", "[modtrig]", function(){
                let data = $(this).attr("modtrig")
                let url = baseUrl + "index.php/dashboard/modal/" + data
                $("#modallg-content").load(url)
                $("#modallg").modal('show')
            })
            
            $(document).on("click", "[moddel]", function(){
                let data = $(this).attr("moddel").split('//')
                let url = baseUrl + "index.php/process/delete/" + data[1] + "/" + data[2]
                deletedItem = $(this).closest(".item-list")
                $("#deleted-item").html(data[0]);
                $("#delete-btn").attr("href",url);
                $("#modaldelete").modal('show')
            })
            
            $("#delete-btn").click(function(e){
                e.preventDefault();
                deletedItem.remove()
                let url = $(this).attr('href')
                $("#loader").load(url)
                $("#modaldelete").modal('hide')
                let cla = url.replace(baseUrl + "index.php/process/delete/", "")
                cla = cla.replace("/", "-")
                $("."+cla).remove()
            });

            function getPoint(element){
                let template = $("."+element.attr('data-template'))[0]
                element = element[0]

                // get left
                var rect = element.getBoundingClientRect();

                var centerLeftX = rect.left;
                var centerLeftY = rect.top + (rect.height / 2);
                
                // get right
                var rect2 = template.getBoundingClientRect();
                
                
                var centerRightX = rect2.right;
                var centerRightY = rect2.top + (rect2.height / 2);
                

                let totalWidth = centerLeftX - centerRightX 
                let totalHeight = centerLeftY - centerRightY
                
                let left = centerRightX + $('.containers').scrollLeft()

                if(totalHeight < 0){
                    $("#connector").css({
                        "top" : centerLeftY + "px",
                        "left" : left + "px",
                        "height" : Math.abs(totalHeight) + "px",
                        "width" : totalWidth + "px"
                    }).addClass('flip-y')
                } else {
                    if(totalHeight < 5){
                        totalHeight = 5
                    }
                    $("#connector").css({
                        "top" : centerRightY + "px",
                        "left" : left + "px",
                        "height" : totalHeight + "px",
                        "width" : totalWidth + "px"
                    }).removeClass("flip-y")
                }
            }

            // cell styling script here

            $(document).on("click", "[borders]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('borders')
                let target = form.find("[name='style["+position+"]']");
                if($(this).hasClass("btn-secondary")){
                    target.val('')
                } else {
                    target.val('true')
                }

                $(this).toggleClass('btn-secondary')
                $(this).toggleClass('btn-outline-secondary')
            })

            $(document).on("click", "[horizontal-align]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('horizontal-align')
                let target = form.find("[name='style[horizontal]']");
                if($(this).hasClass("active")){
                    $(this).removeClass('active')
                    target.val('')
                } else {
                    form.find('[horizontal-align]').removeClass('active');
                    $(this).addClass('active')
                    target.val(position)
                }
            })

            $(document).on("click", "[vertical-align]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('vertical-align')
                let target = form.find("[name='style[vertical]']");
                if($(this).hasClass("active")){
                    $(this).removeClass('active')
                    target.val('')
                } else {
                    form.find('[vertical-align]').removeClass('active');
                    $(this).addClass('active')
                    target.val(position)
                }
            })

            $(document).on("click", "[style-type]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('style-type')
                let target = form.find("[name='style["+position+"]']");
                if($(this).hasClass("active")){
                    $(this).removeClass('active')
                    target.val('')
                } else {
                    $(this).addClass('active')
                    target.val("true")
                }
            })
            
            $(document).on("click", "[style-color]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('style-color')
                let target = form.find("[name='style[color]']");
                target.val(position);

                let color = $(this).css("background-color")
                $(this).closest('.collapser').find('.btn-collapser').css("background-color", color)
            })
            
            $(document).on("click", "[style-cell]", function(){
                let form = $(this).closest("form")
                let position = $(this).attr('style-cell')
                let target = form.find("[name='style[cell]']");
                target.val(position);

                let color = $(this).css("background-color")
                $(this).closest('.collapser').find('.btn-collapser').css("background-color", color)
            })

        })

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>