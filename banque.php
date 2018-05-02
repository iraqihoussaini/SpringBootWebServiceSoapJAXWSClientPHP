<?php
$mt=0;
if(isset($_POST['action'])) {
    $action = $_POST['action'];
    if($action=="ok") {

        if (isset($_POST['montant'])) {
            $mt = $_POST['montant'];
            $clientSOAP = new SOAPClient("http://localhost:8585/BanqueWS?WSDL");
            $param = new stdClass();
            $param->montant = $mt;
            $res = $clientSOAP->__soapCall("ConvertionEuroToDh", array($param));

        }
    }
    elseif ($action=="Comptes"){
        $clientSOAP = new SOAPClient("http://localhost:8585/BanqueWS?WSDL");
        $comptesList=$clientSOAP->__soapCall("getComptes",array());
    }
}
?>

<html>
    <body>
        <form action="banque.php" method="post">
            Montant : <input type="text" name="montant" value="<?php echo($mt)?>">
            <input name="action" type="submit" value="ok">
            <input name="action" type="submit" value="Comptes">
        </form>
        <?php if(isset($res)) {?>
            <?php echo($mt)?> en Euro = <?php echo($res->return)?> en DH
        <?php } ?>
        <?php if(isset($comptesList)) {?>
           <table border="1">
               <tr>
                  <th>Code</th>
                   <th>Solde</th>
               </tr>
               <?php foreach($comptesList->return as $cp) { ?>
                   <tr>
                       <td><?php echo($cp->code) ?></td>
                       <td><?php echo($cp->solde) ?></td>
                   </tr>
               <?php }?>
           </table>
        <?php } ?>
    </body>
</html>
