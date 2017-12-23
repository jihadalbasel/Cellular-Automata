<?php
require_once("load.php");
require_once("printboard.php");
?>
<html>
    <head>
        <title>Project :: Cellular Automaton</title>
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css">		
        <?php require_once("js/script.php"); ?>        
    </head>
	
    <body onLoad="loadUp();">
        <div class="col-12" style="margin:20px auto;">
		  <div class="col-md-6" style="text-algin:center;">
		    <table id="board" align="center" style=" background-color: #f3f3f3; padding: 10px; border: 1px solid #e6e6e6; "></table>
            <div style=" text-align: center; margin-top:20px;">
			    <tr>
			        <td colspan="2"><input class="btn btn-warning" tabindex="1" id="tick"    type="button" value="Tick" onClick="tick();"></td>
                    <td colspan="2"><input class="btn btn-success" tabindex="2" id="runstop" type="button" value="Run"></td>
                    <td colspan="2"><input class="btn btn-danger" tabindex="3" id="clear"   type="button" value="Clear" onClick="sim_clear();"></td>					
                </tr>
		    </div>
			
		  </div>
		  <div class="col-md-6" style="text-algin:center;">
		   <div class="col-md-10" style=" background-color: #f3f3f3; padding: 10px; border: 1px solid #e6e6e6; margin-bottom: 10px; border-radius: 4px; ">
		    <div class="col-md-12">
                 <div class="col-xs-12" style="border: 1px solid #ececec; background-color: #337ab7;">
				    <h2 style="color: #ffffff;text-align: center;">Control Panel</h2>
			    </div>
			</div>
			
			<div class="col-md-12" style=" border-bottom: 2px solid #e6e6e6; padding-bottom: 10px; ">
			    <div class="col-xs-12">
				    <h4 style="color:#337ab7;">Patterns</h4>
			    </div>
			    <div class="col-xs-12">
				    <tr>			     
					    <td><input class="btn btn-primary" tabindex="4" id="shape"   type="button" value="Gosper Glider Gun" onClick="Gosper_glider_gun();"></td>
					    <td><input class="btn btn-primary" tabindex="4" id="shape"   type="button" value="Random Initial Conditions" onClick="random_initial();"></td>
                    </tr>										    
                </div>			
			</div>
		   
		    <div class="col-md-12" style=" border-bottom: 2px solid #e6e6e6; padding-bottom: 10px; ">
			    <div class="col-xs-12">
				    <h4 style="color:#337ab7;">Color</h4>
			    </div>
			    <div class="col-xs-12">
                    <div class="btn-group">
						<select id="colormode1" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <option value="0">Single Color</option>
                            <option value="1">Random</option>
                            <option value="2">Gradient</option>
                        </select>
					</div>
                    <div class="btn-group">
						<select id="colormode2" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <option value="0">Per Cell</option>
                            <option value="1">Per Tick</option>
                        </select>
					</div>
                    <div class="btn-group">
					    <select id="colormode3" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <option value="0">New Cells</option>
                            <option value="1">All Cells</option>
                        </select>
					</div>											    
                </div>			
			</div>		  

			<div class="col-md-12">
			    <div class="col-xs-12">
				    <h4 style="color:#337ab7;">Resize</h4>
			    </div>
				
				<div style=" margin-bottom: 20px; ">				    
					<div>
					    <div class="col-xs-6">
						   <div class="col-xs-12" style="padding-bottom: 5px;padding-left: 0px;">
						    <div class="col-xs-12 input-group">
							    <span class="input-group-addon">Rows</span><input tabindex="4" class="form-control" class="thin" type="textbox" id="nrows">
						    </div>
						   </div>
						   <div class="col-xs-12" style="padding-left: 0px;">
						    <div class="col-xs-12 input-group">
							    <span class="input-group-addon">Columns</span><input tabindex="5" class="form-control" class="thin" type="textbox" id="ncols">
						    </div>
						   </div>
						</div>
						
						<div class="col-xs-6">
					        <div class="col-xs-12 input-group">
					       	     <span class="input-group-addon">Position</span>
						         <table id="tabbedTable" align="center" cellpadding="0" cellspacing="0" style=" background-color: white; border: 1px solid #ccc; float: left; border-radius: 0px 4px 4px 0px; padding: 4px 23px 4px;">  
 					                <tr id="tabSel2">								    
                                        <td>
									        <table>
											  <tr>
											    <td>
												   <input type="radio" name="resizeAnchor" value="8">
												</td>
												<td>
												   <input type="radio" name="resizeAnchor" value="7">
												</td>
												<td>
												   <input type="radio" name="resizeAnchor" value="6">
												</td>
											  </tr>
                                              <tr>
											    <td>
											       <input type="radio" name="resizeAnchor" value="5">
												</td>
												<td>
												   <input checked type="radio" name="resizeAnchor" value="4">
												</td>
												<td>
												    <input type="radio" name="resizeAnchor" value="3">
												</td>
											  </tr>
											  <tr>
											    <td>
												   <input type="radio" name="resizeAnchor" value="2">
												</td>
											    <td>
												   <input type="radio" name="resizeAnchor" value="1">
												</td>
												<td>
												   <input type="radio" name="resizeAnchor" value="0">
												</td>
											  </tr>

										    </table>
									    </td>
                                    </tr>               
			                    </table>
					        </div>
					    </div>
					
				        <div class="col-xs-12" style=" text-align: center; margin-top: 10px; ">				    
					        <div class="col-xs-12">						
							    <input tabindex="6" class="btn btn-primary" type="button"  value="Resize Board" onClick="resize(document.getElementById('nrows').value,document.getElementById('ncols').value);">
						    </div>
				        </div>				
						
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12" style=" border-top: 2px solid #e6e6e6; padding-bottom: 10px; margin-top: 10px;">
			    <div class="col-xs-12">
				    <h4 style="color:#337ab7;">Convert to image</h4>
			    </div>
				
				<div class="col-xs-12">				    
					    <div>
					        <input id="simsave" class="btn btn-primary" type="button" value="Image Capture" onClick="saveSetup();">						    
							<div class="col-xs-6" style=" padding-left: 0px;">
						          <input id="saveData" class="form-control" placeholder="URL Autofill" type="textbox" disabled>
					        </div>
						</div>					
				</div>
				
				<div class="col-xs-12" style=" margin-top: 20px; ">
				    <div class="col-xs-6" style=" padding-left: 0px; ">
					    <div class="col-xs-12 input-group">
					        <span class="input-group-addon">Speed No.</span> <input id="record" class="form-control" placeholder="1 Slow, 60 Fast"  type="textbox" class="thin">
					    </div>
					</div>
					<div class="col-xs-6" style=" padding-left: 0px; ">
					    <input type="button" class="btn btn-primary" value="Generate GIF Image" onClick="openImage()">
				    </div>
				</div>
				
			</div>		  
		  
           </div>
		  </div>	
        </div>
    </body>
</html>
