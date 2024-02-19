<h1>Ownership</h1>
<h5>Current Project Owner:</h5>
<div class="d-flex align-items-center" >
    <div id="comparison-setting-ownership-avatar" >
        <span class="avatar-sm avatar" >    
            <img alt="..." src="<?php echo base_url("assets/images/avatar.jpg");?>" />
        </span>
    </div>
    <div style="margin-left:10px;" >
        <h5><?php echo $login_user->first_name."  ".$login_user->last_name; ?></h5>
        <h6><?php echo $login_user->email;?></h6>
    </div>
</div>
<div class="card" style="border:1px solid lightgray;" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-10" >
                <h5>Transfer ownership</h5>
                <p>Transfer this project to another user.</p>
            </div>
            <div class="col-md-2 d-flex align-items-center " >
                <div class="flex-grow-1" ></div>
                <button class="btn btn-primary" >Transfer</button>
            </div>
        </div>
        
    </div>
</div>
<h4>Danger Zone</h4>
<div class="card" style="border:1px solid pink;" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-10" >
                <h5>Change base currency</h5>
                <p>Changing base currency for this project can have unintended consequences.
                    Current base currency: United States Dollar (USD)
                </p>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <div class="flex-grow-1" ></div>
                <button   class="btn btn-danger" >Change base currency</button>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-10" >
                <h5>Archive this project</h5>
                <p>
                    Mark this project as archived and read-only.
                </p>
            </div>
            <div class="col-md-2 d-flex align-items-center" >
                <div class="flex-grow-1" ></div>
                <button class="btn btn-danger" >Archive</button>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-10" >
                <h5>Delete this project</h5>
                <p>Once you delete a project, there is no going back. Please be certain.</p>
            </div>
            <div class="col-md-2 d-flex align-items-center" >
                <div class="flex-grow-1" ></div>
                <button class="btn btn-danger" >Delete</button>
            </div>
        </div>
    </div>
</div>