<script>
    $(document).ready(function() {
        var action = "<?php echo $action ?>";
        switch(action) {
            case 'view' :
                 $('#userform').find('input, select, textarea,button').prop('readonly', true).prop('disabled', true);
                 break;
            case 'edit' :
                 $('#userform').find('input[name="mail_id"]').prop('readonly', true);
                 break;
            case 'delete' :
                 $('#userform').find('input, select, textarea').prop('readonly', true);
                 $('#userform').find('select').prop('disabled', true);
                 break;
        }
        
    });
</script>