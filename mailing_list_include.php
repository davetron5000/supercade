<script language="Javascript" type="text/javascript">

var fieldstocheck = new Array();
fieldnames = new Array();

function checkform() {
    for (i=0;i<fieldstocheck.length;i++) {
        if (eval("document.subscribeform.elements['"+fieldstocheck[i]+"'].value") == "") {
            alert("Please enter your "+fieldnames[i]);
            eval("document.subscribeform.elements['"+fieldstocheck[i]+"'].focus()");
            return false;
            }
        }

        if(! compareEmail())
        {
            alert("Email addresses you entered do not match");
            return false;
        }
    return true;
}


function addFieldToCheck(value,name) {
    fieldstocheck[fieldstocheck.length] = value;
    fieldnames[fieldnames.length] = name;
}

function compareEmail()
{
    return (document.subscribeform.elements["email"].value == document.subscribeform.elements["emailconfirm"].value);
}

</script>

<form action="http://www.supercadedc.com/phplist/?p=subscribe&id=1" method=post name="subscribeform">
<table id="listform">
<tr><td><div class="required">Email</div></td>
<td class="attributeinput"><input class="attributeinput" type=text name=email value="" size="25">
<script language="Javascript" type="text/javascript">addFieldToCheck("email","Email");</script></td></tr>
<tr><td><div class="required">Name</div></td><td class="attributeinput">
<input type=text name="attribute1"  class="attributeinput" size="25" value=""><script language="Javascript" type="text/javascript">addFieldToCheck("attribute1","Name");</script></td></tr>

<tr><td><div class="required">Zip</div></td><td class="attributeinput">
<input type=text name="attribute2"  class="attributeinput" size="6" value=""><script language="Javascript" type="text/javascript">addFieldToCheck("attribute2","Zip");</script></td></tr>
<tr><td></td><td class="attributeinput"><input type=submit name="subscribe" value="Subscribe to the Supercade Mailing List" onClick="return checkform();"></td></tr>
</table><input type="hidden" name="list[2]" value="signup"><input type="hidden" name="listname[2]" value="Supercade News"/>
</form>

