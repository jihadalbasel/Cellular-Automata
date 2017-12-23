<script>
<?php loadPage(); ?>
var DEAD = "lightgray";
var ALIVE = "green";
var interval = null;
var lastRun = null;
var tabClicked = 0;
var lastColor = null;
            
function encodeBoard()
{
	var toR = "";
    for(var i=0; i<board.length; i+=6)
    {
		var num = 0;
        for(var j=0; j<6; j++)
            if(board[i+j])
                num += Math.pow(2,j);
                toR += ALPHA[num];
    }
    toR = toR.replace(/^(0?.*?)0+$/,"$1");  // remove trailing 0s
    toR = toR.replace(/0{3,66}|-{3,66}/g, function(mtch)
    {return (mtch[0]=="0"?"{":"}")+ALPHA[mtch.length-3];});
                return toR;
}
            
function toggleColor(somewhere, aliveColor, ignoreBoard, set)
{
	if(!somewhere.id)
        somewhere = document.getElementById(somewhere);
    var id = parseInt(somewhere.id.substring(1));
    if(arguments.length < 3)
        set = !board[id];
    if(!ignoreBoard)
        board[id] = set;
    if(!isNaN(aliveColor))
    {
		aliveColor = aliveColor.toString(16);
        while(aliveColor.length < 6)
          aliveColor = "0"+aliveColor;
          aliveColor = "#"+aliveColor;
    }
    somewhere.style.backgroundColor = (set?aliveColor:DEAD);
}
            
function printBoard()
{
    var toR = "";
    for(var i=0; i<r; i++)
    {
        toR += "<tr>";
        for(var j=0; j<c; j++)
        {
            var ind = i*c+j;
            toR += "<td id='s"+ind+"' onClick='toggleColor(this, ALIVE);' style='background-color:"+(board[ind]?ALIVE:DEAD)+"'>&nbsp;</td>";
        }
        toR += "</tr>";
    }
    document.getElementById("board").innerHTML = toR;
}
            
function randomColor()
{
	return (Math.floor(Math.random()*0xCC)<<16) + (Math.floor(Math.random()*0xCC)<<8) + (Math.floor(Math.random()*0xCC));
}
            
function gradient()
{
    if(!lastColor)
    {
        lastColor = 0xFF0000;
        return lastColor.toString(16);
    }
    var re = lastColor >> 16;
    var gr = (lastColor >> 8)%256;
    var bl = lastColor%256;
    var amt = 0x10;
                
    re = Math.min(0xFF, re+(re<0xFF && gr==0 && bl==0xFF)*amt);
    gr = Math.min(0xFF, gr+(re==0xFF && gr<0xFF && bl==0)*amt);
    bl = Math.min(0xFF, bl+(re==0 && gr==0xFF && bl<0xFF)*amt);
                
    re = Math.max(0, re-(re>0 && gr==0xFF && bl==0)*amt);
    gr = Math.max(0, gr-(re==0 && gr>0 && bl==0xFF)*amt);
    bl = Math.max(0, bl-(re==0xFF && gr==0 && bl>0)*amt);
                
    lastColor = (re<<16) + (gr<<8) + bl;
    var toR = lastColor.toString(16);
    while(toR.length < 6)
    toR = "0"+toR;
    return toR;
}
            
function tick()
{
    var cm1 = parseInt(document.getElementById("colormode1").value);
    var cm2 = parseInt(document.getElementById("colormode2").value);
    var cm3 = parseInt(document.getElementById("colormode3").value);
    var aliveColor = (cm1==1?randomColor():(cm1==2 && cm2==1?gradient():ALIVE));
    var save = [];
    var identical = Boolean(interval);  // might need to stop, if running
    for(var i=0; i<board.length; i++)
    {
        var neigh = 0;
        for(var j=-c; j<=c; j+=c)       // vertical
            for(var k=-(i%c!=0); k<=(i%c!=c-1); k++)    // horizontal
                if(!(k==0 && j==0) && board[i+j+k]) // alive and not yourself
                    neigh++;            // a neighbor!
        var living = (neigh==3 || (neigh==2 && board[i]));
        save.push(living);
        if(board[i] != living)
            identical = false;
        if(board[i] != living || cm3)
             toggleColor("s"+i, (cm2==1 || cm1==0?aliveColor:(cm1==2?gradient():randomColor())), true, living);
    }
    if(identical)
        sim_stop();
    board = save;
}
            
function sim_run()
{
    lastRun = encodeBoard();
    var button = document.getElementById("runstop");
    button.value = "Stop";
    button.removeEventListener("click", sim_run, false);
    button.addEventListener("click", sim_stop, false);
    interval = window.setInterval(tick, 200);
}
            
function sim_stop()
{
    interval = window.clearInterval(interval);
    var button = document.getElementById("runstop");
    button.value = "Run";
    button.removeEventListener("click", sim_stop, false);
    button.addEventListener("click", sim_run, false);
}
            
function sim_clear()
{
    for(var i=0; i<r*c; i++)
    toggleColor("s"+i, ALIVE, false, false);
}
			
function random_initial()
{
	var randomArr = ["s51", "s52", "s54", "s56", "s58", "s60", "s63", "s66", "s67", "s74", "s78", "s84", "s86", "s87", "s90", "s96", "s97", "s98", "s105", "s107", "s108", "s109", "s110", "s111", "s112", "s121", "s122", "s127", "s136", "s137", "s138", "s139", "s142", "s148", "s152", "s158", "s161", "s162", "s163", "s169", "s170", "s171", "s174", "s179", "s181", "s183", "s184", "s188", "s189", "s193", "s195", "s198", "s201", "s206", "s207", "s208", "s209", "s210", "s211", "s213", "s214", "s217", "s218", "s219", "s223", "s224", "s228", "s233", "s236", "s243", "s249", "s251", "s252", "s256", "s261", "s262", "s268", "s270", "s274", "s275", "s276", "s278", "s281", "s285", "s289", "s298", "s300", "s308", "s312", "s313", "s315", "s326", "s328", "s330", "s333", "s334", "s335", "s341", "s345", "s351", "s354", "s355", "s358", "s362", "s367", "s370", "s376", "s379", "s380", "s381", "s386", "s393", "s394", "s397", "s401", "s402", "s403", "s404", "s414", "s419", "s421", "s422", "s425", "s428", "s429", "s430", "s432", "s433", "s437", "s441", "s442", "s443", "s447", "s451", "s452", "s455", "s458", "s460", "s462", "s467", "s471", "s476", "s478", "s482", "s483", "s485", "s487", "s488", "s489", "s495", "s497", "s499", "s506", "s507", "s509", "s514", "s516", "s518", "s522", "s527", "s534", "s537", "s541", "s542", "s543", "s545", "s547", "s548", "s549", "s552", "s553", "s562", "s565", "s568", "s572", "s575", "s578", "s579", "s580", "s588", "s592", "s593", "s601", "s602", "s604", "s605", "s608", "s611", "s615", "s616", "s617", "s619", "s620", "s621", "s624", "s628", "s631", "s632", "s634", "s637", "s643", "s645", "s648", "s649", "s650", "s651", "s652", "s653", "s656", "s660", "s661", "s667", "s669", "s671", "s672", "s676", "s678", "s683", "s687", "s689", "s690", "s691", "s693", "s695", "s703", "s704", "s709", "s711", "s714", "s722", "s725", "s726", "s729", "s730", "s735", "s746", "s747", "s750", "s751", "s753", "s756", "s763", "s765", "s770", "s776", "s781", "s789", "s794", "s796", "s802", "s803", "s808", "s809", "s814", "s816", "s818", "s824", "s828", "s832", "s834", "s835", "s836", "s837", "s838", "s843", "s847", "s860", "s861", "s862", "s864", "s866", "s868", "s869", "s875", "s876", "s881", "s882", "s884", "s888", "s894", "s895", "s898", "s903", "s904", "s905", "s910", "s913", "s917", "s932", "s935", "s937", "s941", "s948", "s953", "s956", "s957", "s961", "s962", "s963", "s964", "s966", "s975", "s977", "s979", "s981", "s983", "s984", "s985", "s986", "s987", "s988", "s989", "s994", "s995", "s998", "s1004", "s1006", "s1007", "s1019", "s1020", "s1024", "s1029", "s1030", "s1031", "s1033", "s1035", "s1044", "s1046", "s1049", "s1052", "s1054", "s1057", "s1064", "s1067", "s1069", "s1077", "s1082", "s1084", "s1086", "s1089", "s1091", "s1101", "s1107", "s1108", "s1110", "s1113", "s1114", "s1122", "s1125", "s1127", "s1131", "s1133", "s1137", "s1142", "s1148", "s1149", "s1151", "s1152", "s1153", "s1155", "s1161", "s1162", "s1166", "s1167", "s1169", "s1177", "s1180", "s1181", "s1185", "s1186", "s1196", "s1197", "s1203", "s1206", "s1211", "s1218", "s1223", "s1225", "s1231", "s1235", "s1242", "s1243", "s1244", "s1245", "s1246", "s1248", "s1252", "s1254", "s1256", "s1268", "s1271", "s1275", "s1276", "s1278", "s1288", "s1294", "s1308", "s1311", "s1312", "s1314", "s1317", "s1327", "s1329", "s1330", "s1331", "s1336", "s1342", "s1344", "s1346", "s1350", "s1351", "s1353", "s1355", "s1356", "s1365", "s1369", "s1370", "s1372", "s1373", "s1377", "s1379", "s1380", "s1381", "s1385", "s1387", "s1388", "s1391", "s1392", "s1395", "s1404", "s1406", "s1410", "s1412", "s1419", "s1420", "s1421", "s1423", "s1428", "s1435", "s1437", "s1442", "s1444", "s1448", "s1449", "s1450", "s1452", "s1454", "s1457", "s1462", "s1463", "s1464", "s1465", "s1466", "s1469", "s1470", "s1471", "s1473", "s1485", "s1486", "s1493", "s1494", "s1496", "s1498", "s1502", "s1503", "s1517", "s1524", "s1526", "s1528", "s1537", "s1538", "s1539", "s1540", "s1541", "s1542", "s1549", "s1551", "s1552", "s1553", "s1554", "s1555", "s1557", "s1558"];
	for (var i = 0; i < randomArr.length; i++) 
    {
        document.getElementById(randomArr[i]).click();
	}
}			
			
function Gosper_glider_gun()
{
	var gosperArr = ["s177", "s213", "s215", "s241", "s242", "s249", "s250", "s263", "s264", "s278", "s282", "s287", "s288", "s301", "s302", "s305", "s306", "s315", "s321", "s325", "s326", "s343", "s344", "s353", "s357", "s359", "s360", "s365", "s367", "s391", "s397", "s405", "s430", "s434", "s469", "s470"];
	for (var i = 0; i < gosperArr.length; i++) 
	{
		document.getElementById(gosperArr[i]).click();
	}
}
			
function saveSetup(encoding)
{
    var toR = (window.location.href+"").replace(/\?.*$/,"");
    document.getElementById("saveData").value = toR+"?load="+(encoding?encoding:encodeBoard())+"&r="+r+"&c="+c;
}
            
function ajaxCall(url, func)
{
    var xmlhttp = ((window.XMLHttpRequest)?(xmlhttp=new XMLHttpRequest()):(xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")));
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            func(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send();
    return true;
}
            
function resize(rows, cols)
{
    rows = parseInt(rows)-r;
    cols = parseInt(cols)-c;
    var center = 5;
    var boxes = document.getElementsByName("resizeAnchor");
    for(var i=0; i<9; i++)
        if(boxes[i].checked)
        {
            center = boxes[i].value;
            break;
        }
    var halign = (center%3)-1;
    var valign = Math.floor(center/3)-1;
               
    var args = [];
    var zeroes = fill(c*rows, 0);  // a row
                
    if(valign != 1)
    {
        var cut = Math.max(0,-c*Math.ceil(valign?rows:rows/2));
        args = [r*c-cut, cut].concat(zeroes.slice(valign?0:c*Math.ceil(rows/2))); // add rows to the bottom
        Array.prototype.splice.apply(board, args);
    }
    if(valign != -1)
    {
        args = [0, Math.max(0,-c*Math.floor(valign?rows:rows/2))].concat(zeroes.slice(valign?0:c*Math.floor(rows/2)));   // add rows to the top
        Array.prototype.splice.apply(board, args);
    }
    r += rows;
                
    zeroes = fill(cols, 0);
    for(var i=r; i>0; i--)
    {
        if(halign != 1)
        {
            var cut = Math.max(0,-Math.floor(halign?cols:cols/2));
            args = [i*c-cut, cut].concat(zeroes.slice(halign?0:Math.floor(cols/2))); // add cols to the right
            Array.prototype.splice.apply(board, args);
        }
        if(halign != -1)
        {
            args = [(i-1)*c, Math.max(0,-Math.ceil(halign?cols:cols/2))].concat(zeroes.slice(halign?0:Math.ceil(cols/2))); // add cols to the left
            Array.prototype.splice.apply(board, args);
        }
    }
    c += cols;
                
    printBoard();
}
            
function loadUp()
{
	document.getElementById("runstop").addEventListener("click", sim_run, false);
	document.getElementById("nrows").value = r;
	document.getElementById("ncols").value = c;
	printBoard();
}
            
function fill(amt, val)
{
    var ar = [];
    for(var i=0; i<amt; i++)
    ar.push(val);
    return ar;
}
            
function openImage()
{
    var record = document.getElementById("record").value;
    window.open( "buildImage.php?load="+encodeBoard()+"&r="+r+"&c="+c+"&record="+record );
}

</script>