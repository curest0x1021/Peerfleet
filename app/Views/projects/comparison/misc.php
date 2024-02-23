<!---->
<div style="overflow-x:auto;"  >
            <div class="d-flex align-items-center" >
                <div class="flex-grow-1" style="padding:5px;min-width:15vw;" ></div>
                <?php
                for ($i=0; $i <$numberYards ; $i++) { 
                    
                ?>
                <div style="padding:5px;min-width:15vw;" >
                    <?php echo modal_anchor(get_uri('projects/modal_select_yard/'.$allYards[$i]->id),'<button class="btn btn-primary btn-select-yard-candidate" >Select candidate</button>',array());?>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="d-flex align-items-center">
                <div class="flex-grow-1" style="padding:5px;min-width:15vw;"></div>
                <?php
                for ($i=0; $i <$numberYards ; $i++) { 
                    # code...
                
                    # code...
                ?>  
                    <div class="d-flex " style="padding:5px;min-width:15vw;" >
                        <div class="flex-grow-1" ><?php echo $allYards[$i]->title;?></div>
                        <div class="dropdown" >
                            <button class="btn btn-sm btn-default dropdown-toggle" data-bs-toggle="dropdown" >
                                <i data-feather="more-vertical" ></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo get_uri('projects/download_yard_xlsx/'.$allYards[$i]->id);?>" target="_blank">Export xlsx</a></li>
                                <li><?php echo modal_anchor(get_uri('projects/modal_import_yard_xlsx/'.$allYards[$i]->id),'<li class="dropdown-item" >Import quotation</l1>',array());?></li>
                                <li><?php echo modal_anchor(get_uri('projects/modal_yard_add_files/'.$allYards[$i]->id),'<li class="dropdown-item" >Add files</l1>',array());?></li>
                                <li><?php echo modal_anchor(get_uri('projects/modal_select_yard/'.$allYards[$i]->id),'<li class="dropdown-item" >Select candidate</l1>',array());?></li>
                            </ul>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <!---->