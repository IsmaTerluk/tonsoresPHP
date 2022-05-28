<p> <?= $_SESSION['user']['rol']?> </p>
    
<p> 
    <?php  
        if(isset($array['restringir_acceso']))
          echo $array['restringir_acceso'];
    ?> 
</p>