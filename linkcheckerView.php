<div class="one_url">
    <div>
        URL: <?= $this->url ?>
    </div>
    <div>
        DESCRIPTION: <?= $this->description ?>
    </div>    
    <?php     
    if ($this->result->error_text != '') {
    ?>    
    <div>
        ERROR: <?= $this->result->error_text ?>
    </div>
    <?php 
    }
    ?>
    <div>
        HTTP CODE: <?= $this->result->http_code ?>
    </div>
   
    <?php    
    if ($this->result->redirect_location != '') {
    ?>
    <div>
        REDIRECT LOCATION: <?= $this->result->redirect_location ?>
    </div>
    <?php
    }
    ?>
</div>
