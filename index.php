<?php
    require_once 'connection.php';
    $sql1="DROP PROCEDURE IF EXISTS GetNotes";
    $sql2="CREATE PROCEDURE GetNotes()
    BEGIN
        SELECT * FROM notes JOIN notes_logs ON notes.id = notes_logs.noteId;
    END;";
    $stmt1=$con->prepare($sql1);
    $stmt2=$con->prepare($sql2);
    $stmt1->execute();
    $stmt2->execute(); 
    
    $sqlGet='CALL GetNotes()';

    $q=$con->query($sqlGet);
    $q->setFetchMode(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="utf-8">
    <title>Notes App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/mainStyle.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div class="page-content container note-has-grid">
        <ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2 active" id="all-category">
                    <i class="icon-layers mr-1"></i><span class="d-none d-md-block">All Notes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-business"> <i class="icon-briefcase mr-1"></i><span class="d-none d-md-block">Business</span></a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-social"> <i class="icon-share-alt mr-1"></i><span class="d-none d-md-block">Social</span></a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-important"> <i class="icon-tag mr-1"></i><span class="d-none d-md-block">Important</span></a>
            </li>
            <li class="nav-item ml-auto">
                <a href="javascript:void(0)" class="nav-link btn-primary rounded-pill d-flex align-items-center px-3" id="add-notes"> <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Add Notes</span></a>
            </li>
        </ul>
        <div class="tab-content bg-transparent">
            <div id="note-full-container" class="note-has-grid row">
                <?php while ($res=$q->fetch()): ?>
                    <div class="col-md-4 single-note-item all-category <?php echo $res['category'];?>" style="">
                        <div class="card card-body">
                            <span class="side-stick"></span>
                            <h5 class="note-title text-truncate w-75 mb-0"><?php echo $res['title'];?><i class="point fa fa-circle ml-1 font-10"></i></h5>
                            <p class="note-date font-12 text-muted"><?php echo $res['updateTime']?></p>
                            <div class="note-content">
                                <p class="note-inner-content text-muted"><?php echo $res['text'];?></p>
                            </div>
                            <div class="d-flex align-items-center">
                                <form action="deleteNote.php" method="post" class="mr-1">
                                    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                                <div class="ml-auto"> 
                                    <form id="myForm" action="updateCategory.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                                        <select name="categories" onchange="this.form.submit()">
                                            <option value="All">All</option>
                                            <option value="note-important" <?php if($res['category'] == "note-important"){ echo "selected";}?>>Important</option>
                                            <option value="note-business" <?php if($res['category'] == "note-business"){ echo "selected";}?>>Business</option>
                                            <option value="note-social" <?php if($res['category'] == "note-social"){ echo "selected";}?>>Social</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="modal fade" id="addnotesmodal" tabindex="-1" role="dialog" aria-labelledby="addnotesmodalTitle" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title text-white">Add Notes</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="insertNote.php" id="addnotesmodalTitle" method="post">
                        <div class="modal-body">
                            <div class="notes-box">
                                <div class="notes-content">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="note-title">
                                                <label>Note Title</label>
                                                <input type="text" name="title" id="note-has-title" class="form-control" placeholder="Title"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="note-description">
                                                <label>Note Description</label>
                                                <textarea id="note-has-description" name="description" class="form-control" placeholder="Description" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btn-n-save" class="float-left btn btn-success" style="display: none;">Save</button>
                            <button class="btn btn-danger" data-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/mainScript.js"></script>
</body>
