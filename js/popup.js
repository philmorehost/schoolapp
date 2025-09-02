function popUpAlert(popUpArray,popUpArrayName){
	if(popUpArray[0] != ""){
		viewBtnHTML = 	'<a href="'+popUpArray[0]+'" style="text-decoration: none;">\
							<button type="button" style="text-align: left; position: relative;" class="button-box color-1 bg-3 onhover-bg-color-6 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
								<img src="imgfile/fa-eye.png" class="mobile-width-6 system-width-9 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1" /> '+popUpArrayName[0]+'\
							</button>\
						</a>';
	}else{
		viewBtnHTML = '';
	}
	
	if(popUpArray[1] != ""){
		approveBtnHTML = 	'<a href="'+popUpArray[1]+'" style="text-decoration: none;">\
							<button type="button" style="text-align: left; position: relative;" class="button-box color-1 bg-3 onhover-bg-color-6 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
								<img src="imgfile/fa-approve.png" class="mobile-width-6 system-width-9 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1" /> '+popUpArrayName[1]+'\
							</button>\
						</a>';
	}else{
		approveBtnHTML = '';
	}
	
	if(popUpArray[2] != ""){
		editBtnHTML = 	'<a href="'+popUpArray[2]+'" style="text-decoration: none;">\
							<button type="button" style="text-align: left; position: relative;" class="button-box color-1 bg-3 onhover-bg-color-6 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
								<img src="imgfile/fa-edit.png" class="mobile-width-6 system-width-9 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1" /> '+popUpArrayName[2]+'\
							</button>\
						</a>';
	}else{
		editBtnHTML = '';
	}
	
	if(popUpArray[3] != ""){
		deleteBtnHTML = '<a href="'+popUpArray[3]+'" style="text-decoration: none;">\
							<button type="button" style="text-align: left; position: relative; color: red;" class="button-box bg-3 onhover-bg-color-6 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
								<img src="imgfile/fa-delete.png" class="mobile-width-6 system-width-9 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1" /> '+popUpArrayName[3]+'\
							</button>\
						</a>';
	}else{
		deleteBtnHTML = '';
	}

	closeBtnHTML = '<a onclick="closePopUp(`popup-div`);" style="text-decoration: none;">\
						<button type="button" style="text-align: left; position: relative; color: red;" class="button-box bg-3 onhover-bg-color-6 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
							<img src="imgfile/fa-close.png" class="mobile-width-6 system-width-9 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-1 system-margin-right-1" /> Close\
						</button>\
					</a>';
	
	if(((popUpArray[0] != "") || (popUpArray[1] != "")) && (popUpArray[2] != "") && (popUpArray[3] != "")){
		ViewEditDivBegin = '<div style="" class="container-box bg-3 border-style-bottom-1 border-color-5 border-width-1 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">';
		ViewEditDivEnd = '</div>';
	}else{
		ViewEditDivBegin = '';
		ViewEditDivEnd = '';
	}

	if((popUpArray[0] != "") || (popUpArray[1] != "") || (popUpArray[2] != "") || (popUpArray[3] != "")){
		ViewEditDivBegin_2 = '<div style="" class="container-box bg-3 border-style-bottom-1 border-color-5 border-width-1 mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">';
		ViewEditDivEnd_2 = '</div>';
	}else{
		ViewEditDivBegin_2 = '';
		ViewEditDivEnd_2 = '';
	}
	
	const createPopUp_1 = document.createElement("div");
    createPopUp_1.className = "popup-div bg-2 box-shadow border-radius-5px";
    createPopUp_1.innerHTML = 
    '<center>\
    <div style="text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
    	'+ViewEditDivBegin+'\
    		'+viewBtnHTML+'\
    		'+approveBtnHTML+'\
    		'+editBtnHTML+'\
    	'+ViewEditDivEnd+'\
		'+ViewEditDivBegin_2+'\
    		'+deleteBtnHTML+'\
		'+ViewEditDivEnd_2+'\
		'+closeBtnHTML+'\
    </div>\
    </center>';

	if(document.getElementsByClassName("popup-div").length === 0){
       	document.body.appendChild(createPopUp_1);
    }else{
    	document.getElementsByClassName("popup-div")[0].remove();
    	document.body.appendChild(createPopUp_1);
    }
}

function closePopUp(popUpClassName){
	document.getElementsByClassName(popUpClassName)[0].remove();
}


//Large Pop Up
function largePopUp(popUpTitle, popUpPlaceholder, popUpBtnText, popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const getSelectTagInfo = document.getElementById(popUpSelectTagId);
	
	closeBtnHTML = '<img onclick="closeLargePopUp(`largepopup-div`);" src="imgfile/Close.png" style="float: right; clear: right;" class="mobile-width-10 system-width-3 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1" />';
	titleHTML = '<span style="float: left; clear: left;" class="mobile-font-size-20 system-font-size-22 text-bold-300 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">'+popUpTitle+'</span>';
	
	const createPopUp_1 = document.createElement("div");
    createPopUp_1.className = "largepopup-div bg-2 box-shadow border-radius-5px";
    createPopUp_1.innerHTML = 
    '<center>\
    <div style="text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
  		<div style="text-align: left; display: block;" class="mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-2 system-margin-bottom-2">\
  			'+closeBtnHTML+'\
  			'+titleHTML+'\
  		</div><br>\
  		<center>\
  			<div style="text-align: left; display: block;" class="mobile-width-100 system-width-100 mobile-margin-top-5 system-margin-top-5 mobile-margin-bottom-0 system-margin-bottom-0">\
  				<div class="form-group mobile-width-90 system-width-65 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-0 system-margin-right-2">\
  					<input id="popup-item-input" type="text" placeholder="'+popUpPlaceholder+'" class="form-input" required/>\
  					<span class="form-span mobile-font-size-12 system-font-size-14"></span>\
  				</div>\
  				<button onclick="popUpAddItemBtn(`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" type="button" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-94 system-width-26 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-0 system-margin-right-1">\
  					'+popUpBtnText+'\
  				</button><br>\
				<div id="largepopup-items-div" class="mobile-width-100 system-width-100">\
				</div>\
  			</div>\
  		</center>\
    </div>\
    </center>';

	if(document.getElementsByClassName("largepopup-div").length === 0){
       	document.body.appendChild(createPopUp_1);
    }else{
    	document.getElementsByClassName("largepopup-div")[0].remove();
    	document.body.appendChild(createPopUp_1);
    }

	const popUpItemDiv = document.getElementById("largepopup-items-div");
	for(i=0; i < getSelectTagInfo.options.length; i++){
		if(getSelectTagInfo.options[i].value.split(" ")[0].length != 0){
		popUpItemDiv.innerHTML += '<div style="border:0.3px solid var(--color-5); padding: 3% 2%;" id="'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="large-pop-up-attr-'+getSelectTagInfo.options[i].value.split(" ")[0]+' largepopup-items mobile-width-90 system-width-91 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-0 system-margin-right-1 mobile-margin-bottom-2 system-margin-bottom-2">\
										<span id="largepop-span-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-font-size-16 system-font-size-18 text-bold-300 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">'+getSelectTagInfo.options[i].text+'</span>\
										<input type="text" value="'+getSelectTagInfo.options[i].text+'" id="large-pop-up-editbox-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-width-70 system-width-70" style="border:none; outline: none; background: transparent; display: none;"/>\
										<div style="float: right; clear: right; margin: -2% 0 0 0;" class="mobile-width-25 system-width-15">\
											<img onclick="deleteLargePopUpItem(`'+getSelectTagInfo.options[i].value.split(" ")[0]+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Delete.png" style="margin:0 -4% 0 0;" id="large-pop-up-delete-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-width-50 system-width-50" />\
											<img onclick="editLargePopUpItem(`'+getSelectTagInfo.options[i].value.split(" ")[0]+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Edit.png" style="margin:0 0 0 -4%;" id="large-pop-up-edit-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-width-50 system-width-50" />\
											<img onclick="cancelLargePopUpItem(`'+getSelectTagInfo.options[i].value.split(" ")[0]+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/cancel.png" style="margin:0 -4% 0 0; display: none;" id="large-pop-up-cancel-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-width-50 system-width-50" />\
											<img onclick="saveLargePopUpItem(`'+getSelectTagInfo.options[i].value.split(" ")[0]+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/save.png" style="margin:0 0 0 -4%; display: none;" id="large-pop-up-save-'+getSelectTagInfo.options[i].value.split(" ")[0]+'" class="mobile-width-50 system-width-50" />\
										</div>\
									</div>';
		}
	}

}



function closeLargePopUp(popUpClassName){
	document.getElementsByClassName(popUpClassName)[0].remove();
}

function popUpAddItemBtn(popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const popUpItemDiv = document.getElementById("largepopup-items-div");
	const popUpItemInput = document.getElementById("popup-item-input");
	const popUpItemList = document.getElementsByClassName("largepopup-items");
	const countPopUpItemList = popUpItemList.length;
	const getSelectTagInfo = document.getElementById(popUpSelectTagId);
	
	const createOption = document.createElement("option");
	createOption.text = popUpItemInput.value;
	if(popUpItemInput.value.length != ""){
		if(countPopUpItemList === 0){
			let childPopUpList ='<div style="border:0.3px solid var(--color-5); padding: 3% 2%;" id="1" class="large-pop-up-attr-1 largepopup-items mobile-width-90 system-width-91 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-0 system-margin-right-1 mobile-margin-bottom-2 system-margin-bottom-2">\
									<span id="largepop-span-1" class="mobile-font-size-16 system-font-size-18 text-bold-300 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">'+popUpItemInput.value+'</span>\
									<input type="text" value="'+popUpItemInput.value+'" id="large-pop-up-editbox-1" class="mobile-width-70 system-width-70" style="border:none; outline: none; background: transparent; display: none;"/>\
									<div style="float: right; clear: right; margin: -2% 0 0 0;" class="mobile-width-25 system-width-15">\
										<img onclick="deleteLargePopUpItem(`1`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Delete.png" style="margin:0 -4% 0 0;" id="large-pop-up-delete-1" class="mobile-width-50 system-width-50" />\
										<img onclick="editLargePopUpItem(`1`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Edit.png" style="margin:0 0 0 -4%;" id="large-pop-up-edit-1" class="mobile-width-50 system-width-50" />\
										<img onclick="cancelLargePopUpItem(`1`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/cancel.png" style="margin:0 -4% 0 0; display: none;" id="large-pop-up-cancel-1" class="mobile-width-50 system-width-50" />\
										<img onclick="saveLargePopUpItem(`1`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/save.png" style="margin:0 0 0 -4%; display: none;" id="large-pop-up-save-1" class="mobile-width-50 system-width-50" />\
									</div>\
								</div>';
			popUpItemDiv.innerHTML += childPopUpList;
			createOption.value = "1 "+popUpItemInput.value;
			getSelectTagInfo.add(createOption);
			var insertIns = popUpSqlStatement.replace("null",1).split("&&");
			var all_sql_col = "";
			var all_sql_col_val = "";
			for(i=0; i < insertIns.length; i++){
				all_sql_col += insertIns[i].trim().split("=")[0]+"\n";
				all_sql_col_val += insertIns[i].trim().split("=")[1]+"\n";
			}
			var all_sql_col_together = all_sql_col.trim().replace("\n",", ")+", "+popUpSqlUpdateColumn;
			var all_sql_col_value_together = all_sql_col_val.trim().replace("\n",", ")+", '"+popUpItemInput.value+"'";
			var sql_statement = "SELECT * FROM "+popUpSqlTableName+" WHERE "+popUpSqlStatement.replace("null",1);
			var HttpRequestSql = new XMLHttpRequest();
			HttpRequestSql.open("POST","./sql_statement_exists.php");
			HttpRequestSql.setRequestHeader("Content-Type","application/json");
			HttpRequestSqlbody = JSON.stringify({text: sql_statement});
			HttpRequestSql.onload = function(){
				if(HttpRequestSql.readyState == 4 && HttpRequestSql.status == 200){
					var sql_check_res = JSON.parse(HttpRequestSql.responseText)["response"];
					if(sql_check_res === 0){
						popUpBackSql("INSERT INTO "+popUpSqlTableName+" ("+all_sql_col_together+") VALUES ("+all_sql_col_value_together+")");
					}
				}else{
					alert("Status: "+HttpRequestSql.status);
				}
			}
			HttpRequestSql.send(HttpRequestSqlbody);
			popUpItemInput.value = "";
		}else{
			const popUpID = parseInt(document.getElementsByClassName("largepopup-items")[(countPopUpItemList-1)].id);
			let childPopUpList ='<div style="border:0.3px solid var(--color-5); padding: 3% 2%;" id="'+(popUpID+1)+'" class="large-pop-up-attr-'+(popUpID+1)+' largepopup-items mobile-width-90 system-width-91 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-0 system-margin-right-1 mobile-margin-bottom-2 system-margin-bottom-2">\
									<span id="largepop-span-'+(popUpID+1)+'" class="mobile-font-size-16 system-font-size-18 text-bold-300 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1">'+popUpItemInput.value+'</span>\
									<input type="text" value="'+popUpItemInput.value+'" id="large-pop-up-editbox-'+(popUpID+1)+'" class="mobile-width-70 system-width-70" style="border:none; outline: none; background: transparent; display: none;"/>\
									<div style="float: right; clear: right; margin: -2% 0 0 0;" class="mobile-width-25 system-width-15">\
										<img onclick="deleteLargePopUpItem(`'+(popUpID+1)+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Delete.png" style="margin:0 -4% 0 0;" id="large-pop-up-delete-'+(popUpID+1)+'" class="mobile-width-50 system-width-50" />\
										<img onclick="editLargePopUpItem(`'+(popUpID+1)+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/Edit.png" style="margin:0 0 0 -4%;" id="large-pop-up-edit-'+(popUpID+1)+'" class="mobile-width-50 system-width-50" />\
										<img onclick="cancelLargePopUpItem(`'+(popUpID+1)+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/cancel.png" style="margin:0 -4% 0 0; display: none;" id="large-pop-up-cancel-'+(popUpID+1)+'" class="mobile-width-50 system-width-50" />\
										<img onclick="saveLargePopUpItem(`'+(popUpID+1)+'`,`'+popUpSelectTagId+'`,`'+popUpSqlTableName+'`,`'+popUpSqlStatement+'`,`'+popUpSqlUpdateColumn+'`);" src="imgfile/save.png" style="margin:0 0 0 -4%; display: none;" id="large-pop-up-save-'+(popUpID+1)+'" class="mobile-width-50 system-width-50" />\
									</div>\
								</div>';
			popUpItemDiv.innerHTML += childPopUpList;
			createOption.value = (popUpID+1)+" "+popUpItemInput.value;
			getSelectTagInfo.add(createOption);
			var insertIns = popUpSqlStatement.replace("null",(popUpID+1)).split("&&");
			var all_sql_col = "";
			var all_sql_col_val = "";
			for(i=0; i < insertIns.length; i++){
				all_sql_col += insertIns[i].trim().split("=")[0]+"\n";
				all_sql_col_val += insertIns[i].trim().split("=")[1]+"\n";
			}
			var all_sql_col_together = all_sql_col.trim().replace("\n",", ")+", "+popUpSqlUpdateColumn;
			var all_sql_col_value_together = all_sql_col_val.trim().replace("\n",", ")+", '"+popUpItemInput.value+"'";
			var sql_statement = "SELECT * FROM "+popUpSqlTableName+" WHERE "+popUpSqlStatement.replace("null",(popUpID+1));
			var HttpRequestSql = new XMLHttpRequest();
			HttpRequestSql.open("POST","./sql_statement_exists.php");
			HttpRequestSql.setRequestHeader("Content-Type","application/json");
			HttpRequestSqlbody = JSON.stringify({text: sql_statement});
			HttpRequestSql.onload = function(){
				if(HttpRequestSql.readyState == 4 && HttpRequestSql.status == 200){
					var sql_check_res = JSON.parse(HttpRequestSql.responseText)["response"];
					if(sql_check_res === 0){
						popUpBackSql("INSERT INTO "+popUpSqlTableName+" ("+all_sql_col_together+") VALUES ("+all_sql_col_value_together+")");
					}
				}else{
					alert("Status: "+HttpRequestSql.status);
				}
			}
			HttpRequestSql.send(HttpRequestSqlbody);
			popUpItemInput.value = "";
		}
	}
}

function deleteLargePopUpItem(itemID,popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const getSelectTagInfo = document.getElementById(popUpSelectTagId);
	const largePopSpan = document.getElementsByClassName("large-pop-up-attr-"+itemID);
	if(confirm("Are you sure you want to delete this item?")){
		largePopSpan[0].remove();
		for(i=0; i < getSelectTagInfo.length; i++){
			if(getSelectTagInfo.options[i].value.split(" ")[0] === itemID){
				getSelectTagInfo.remove(i);
				popUpBackSql("DELETE FROM "+popUpSqlTableName+" WHERE "+popUpSqlStatement.replace("null",itemID));
			}
		}
	}

}

function editLargePopUpItem(itemID,popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const largePopSpan = document.getElementById("largepop-span-"+itemID);
	largePopSpan.style.display = "none";
	
	const largePopEditBox = document.getElementById("large-pop-up-editbox-"+itemID);
	const largePopDelete = document.getElementById("large-pop-up-delete-"+itemID);
	const largePopEdit = document.getElementById("large-pop-up-edit-"+itemID);
	const largePopCancel = document.getElementById("large-pop-up-cancel-"+itemID);
	const largePopSave = document.getElementById("large-pop-up-save-"+itemID);
	
	largePopEditBox.style.display = "inline-block";
	largePopDelete.style.display = "none";
	largePopEdit.style.display = "none";
	largePopCancel.style.display = "inline-block";
	largePopSave.style.display = "inline-block";
	
	largePopEditBox.focus();
}

function cancelLargePopUpItem(itemID,popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const largePopSpan = document.getElementById("largepop-span-"+itemID);
	largePopSpan.style.display = "inline-block";
	
	const largePopEditBox = document.getElementById("large-pop-up-editbox-"+itemID);
	const largePopDelete = document.getElementById("large-pop-up-delete-"+itemID);
	const largePopEdit = document.getElementById("large-pop-up-edit-"+itemID);
	const largePopCancel = document.getElementById("large-pop-up-cancel-"+itemID);
	const largePopSave = document.getElementById("large-pop-up-save-"+itemID);
	
	largePopEditBox.style.display = "none";
	largePopDelete.style.display = "inline-block";
	largePopEdit.style.display = "inline-block";
	largePopCancel.style.display = "none";
	largePopSave.style.display = "none";
}

function saveLargePopUpItem(itemID,popUpSelectTagId, popUpSqlTableName, popUpSqlStatement, popUpSqlUpdateColumn){
	const getSelectTagInfo = document.getElementById(popUpSelectTagId);
	const largePopSpan = document.getElementById("largepop-span-"+itemID);
	largePopSpan.style.display = "inline-block";
	
	const largePopEditBox = document.getElementById("large-pop-up-editbox-"+itemID);
	const largePopDelete = document.getElementById("large-pop-up-delete-"+itemID);
	const largePopEdit = document.getElementById("large-pop-up-edit-"+itemID);
	const largePopCancel = document.getElementById("large-pop-up-cancel-"+itemID);
	const largePopSave = document.getElementById("large-pop-up-save-"+itemID);
	
	largePopEditBox.style.display = "none";
	largePopDelete.style.display = "inline-block";
	largePopEdit.style.display = "inline-block";
	largePopCancel.style.display = "none";
	largePopSave.style.display = "none";
	
	for(i=0; i < getSelectTagInfo.length; i++){
		if(getSelectTagInfo.options[i].value.split(" ")[0] === itemID){
			getSelectTagInfo.options[i].value = itemID+" "+largePopEditBox.value;
			getSelectTagInfo.options[i].text = largePopEditBox.value;
			popUpBackSql("UPDATE "+popUpSqlTableName+" SET " +popUpSqlUpdateColumn+"='"+largePopEditBox.value+"' WHERE "+popUpSqlStatement.replace("null",itemID));
		}
	}
	largePopSpan.innerHTML = largePopEditBox.value;
}

function popUpBackSql(statement){
	var HttpRequestSql = new XMLHttpRequest();
	HttpRequestSql.open("POST","./sql_statement_exec.php");
	HttpRequestSql.setRequestHeader("Content-Type","application/json");
	HttpRequestSqlbody = JSON.stringify({text: statement});
	HttpRequestSql.onload = function(){
		if(HttpRequestSql.readyState == 4 && HttpRequestSql.status == 200){
			//alert(JSON.parse(HttpRequestSql.responseText)["response"]);
		}else{
			alert("Status: "+HttpRequestSql.status);
		}
	}
	HttpRequestSql.send(HttpRequestSqlbody);
}


//pop up section
function popUpSectionAlert(popUpType, popUpSectionTitle, popUpSectionContent){
	if(popUpType == "txt"){
		if(popUpSectionTitle.length > 0){
			viewPopUpTitle = '<span class="mobile-font-size-20 system-font-size-25 mobile-margin-left-5 system-margin-left-5">'+popUpSectionTitle+'</span>';
		}else{
			viewPopUpTitle = '';
		}
		
		if(popUpSectionContent.length > 0){
			viewPopUpDetail = '<div style="text-align: left;" class="mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">\
								'+popUpSectionContent+'\
							</div>';
		}else{
			viewPopUpDetail = '';
		}
	}
	
	if(popUpType == "html"){
		if(popUpSectionTitle.length > 0){
			viewPopUpTitle = '<span class="mobile-font-size-20 system-font-size-25 mobile-margin-left-5 system-margin-left-5">'+popUpSectionTitle+'</span>';
		}else{
			viewPopUpTitle = '';
		}
		
		if(popUpSectionContent.length > 0){
			let getAllHtmlBlocks = "";
			for(x=0; x < popUpSectionContent.length; x++){
				let contentValue = popUpSectionContent[x].replace(":","").replace(popUpSectionContent[x].split(":")[0],"").trim();
				if(contentValue.length > 0){
					contentValue = contentValue;
				}else{
					contentValue = "N/A";
				}
				getAllHtmlBlocks += '<div style="text-align: left; display: inline-block;" class="color-7 bg-3 mobile-width-45 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-left-1 system-margin-left-1 mobile-margin-right-1 system-margin-right-1 mobile-margin-bottom-2 system-margin-bottom-2">\
										<strong>'+popUpSectionContent[x].split(":")[0]+'</strong>:<br/>\
										'+contentValue+'</strong>\
									</div>';
			}
			viewPopUpDetail = '<div style="text-align: left;" class="mobile-width-90 system-width-90 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">\
								'+getAllHtmlBlocks+'\
							</div>';
		}else{
			viewPopUpDetail = '';
		}
	}
	
	closeBtnHTML = '<a style="text-decoration: none;">\
						<div style="text-align: left;" class="mobile-width-100 system-width-100 mobile-margin-top-0 system-margin-top-0 mobile-margin-bottom-0 system-margin-bottom-0">\
							'+viewPopUpTitle+' <img onclick="closepopUpSection(`popup-section-div`);" src="imgfile/Close.png" style="float: right; clear: left; cursor: pointer;" class="mobile-width-6 system-width-4 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2" /> \
						</div>\
					</a>';
	
	const createpopUpSection_1 = document.createElement("div");
    createpopUpSection_1.className = "popup-section-div bg-2 box-shadow border-radius-5px";
    createpopUpSection_1.innerHTML = 
    '<center>\
    <div class="mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-0 system-margin-bottom-0">\
		'+closeBtnHTML+'\
		'+viewPopUpDetail+'\
    </div>\
    </center>';

	if(document.getElementsByClassName("popup-section-div").length === 0){
       	document.body.appendChild(createpopUpSection_1);
    }else{
    	document.getElementsByClassName("popup-section-div")[0].remove();
    	document.body.appendChild(createpopUpSection_1);
    }
}

function closepopUpSection(popUpSectionClassName){
	document.getElementsByClassName(popUpSectionClassName)[0].remove();
}

function paymentCallBackRecord(school_id, class_id, session_id, student_id, fee_type, amount_paid, payment_ref){

	const classPaymentHttpRequest = new XMLHttpRequest();
	classPaymentHttpRequest.open("POST","./chk-fee.php?type=record");
	classPaymentHttpRequest.setRequestHeader("Content-Type","application/json");
	const classPaymentHttpRequestBody = JSON.stringify({sch_no: school_id, class_id_no: class_id, session: session_id, fee_type: fee_type, admission_no: student_id, amount: amount_paid, ref: payment_ref});
	classPaymentHttpRequest.onload = function(){
		if((classPaymentHttpRequest.readyState == 4) && (classPaymentHttpRequest.status == 200)){
		const classPaymentResponse = JSON.parse(classPaymentHttpRequest.responseText)["response"];
			if(classPaymentResponse == 1){
				alert("list created");
			}
		}else{
			alert(classPaymentHttpRequest.status);
		}
	}
	classPaymentHttpRequest.send(classPaymentHttpRequestBody);
	

}

//Custom Mutiple Select Box
function multipleOptionSelectTag(className){
	let multipleSelect = document.getElementsByClassName(className)[0];
	let custom_multipleSelect = document.getElementsByClassName("custom_select_"+className)[0];
	let custom_multipleFormDivSelect = document.getElementsByClassName("custom_form_div_select_"+className)[0];
	
	custom_SelectCounter = document.createElement("input");
	custom_SelectCounter.setAttribute("class","custom_select_counter_"+className);
	custom_SelectCounter.type = "number";
	custom_SelectCounter.hidden = true;
	custom_SelectCounter.value = 0;
	
	custom_multipleFormDivSelect.appendChild(custom_SelectCounter);
	let get_custom_SelectCounter = document.getElementsByClassName("custom_select_counter_"+className)[0];
	
	let custom_multipleOption;
	
	let custom_multipleDropDownOption;
	custom_multipleDropDownOption = document.createElement("div");
	custom_multipleDropDownOption.setAttribute("class", "dropdown custom_select_dropdown_"+className);
	custom_multipleFormDivSelect.appendChild(custom_multipleDropDownOption);
	let custom_multipleSelectDropDown = document.getElementsByClassName("custom_select_dropdown_"+className)[0];
	
	let custom_multipleDropDownOptionList;
	let custom_multipleDropDownOptionListCheckbox;
	let custom_multipleDropDownOptionListLabel;
	custom_multipleSelectDropDown.innerHTML = "";
	
	if(multipleSelect.length > 0){
		
		setInterval(function(){
			let countChecked = 0;
			let countAllOptions = 0;
			let selectedOptionIndex;
			if(multipleSelect.length > get_custom_SelectCounter.value){
				custom_multipleSelectDropDown.innerHTML = "";
				for(x=0; x < multipleSelect.length; x++){
					if((multipleSelect.options[x].hidden == false) || (multipleSelect.options[x].disabled == false)){
					if(multipleSelect.options[x].selected == true){
						
						custom_multipleDropDownOptionListCheckbox = document.createElement("input");
						custom_multipleDropDownOptionListCheckbox.setAttribute("id","custom_select_dropdown_option_checkbox_"+className+"_"+x);
						custom_multipleDropDownOptionListCheckbox.type = "checkbox";
						custom_multipleDropDownOptionListCheckbox.setAttribute("onclick","chooseOptionSelectTag('"+className+"', "+x+");");
						custom_multipleDropDownOptionListCheckbox.checked = true;
						
						
						custom_multipleDropDownOptionListLabel = document.createElement("label");
						custom_multipleDropDownOptionListLabel.setAttribute("for","custom_select_dropdown_option_checkbox_"+className+"_"+x);
						custom_multipleDropDownOptionListLabel.setAttribute("id","custom_select_dropdown_option_label_"+className+"_"+x);
						custom_multipleDropDownOptionListLabel.setAttribute("onclick","checkboxOptionSelectTag('"+className+"', "+x+");");
						custom_multipleDropDownOptionListLabel.innerHTML = multipleSelect.options[x].text;
						
						custom_multipleDropDownOptionList = document.createElement("div");
						custom_multipleDropDownOptionList.setAttribute("class","listing");
						custom_multipleDropDownOptionList.appendChild(custom_multipleDropDownOptionListCheckbox);
						custom_multipleDropDownOptionList.appendChild(custom_multipleDropDownOptionListLabel);
						
						
						custom_multipleDropDownOption.appendChild(custom_multipleDropDownOptionList);
						
						selectedOptionIndex = x;
						countAllOptions++;
						countChecked++;
					}else{
					
						custom_multipleDropDownOptionListCheckbox = document.createElement("input");
						custom_multipleDropDownOptionListCheckbox.setAttribute("id","custom_select_dropdown_option_checkbox_"+className+"_"+x);
						custom_multipleDropDownOptionListCheckbox.type = "checkbox";
						custom_multipleDropDownOptionListCheckbox.setAttribute("onclick","chooseOptionSelectTag('"+className+"', "+x+");");
						custom_multipleDropDownOptionListCheckbox.checked = false;
						
						
						custom_multipleDropDownOptionListLabel = document.createElement("label");
						custom_multipleDropDownOptionListLabel.setAttribute("for","custom_select_dropdown_option_checkbox_"+className+"_"+x);
						custom_multipleDropDownOptionListLabel.setAttribute("id","custom_select_dropdown_option_label_"+className+"_"+x);
						custom_multipleDropDownOptionListLabel.setAttribute("onclick","checkboxOptionSelectTag('"+className+"', "+x+");");
						custom_multipleDropDownOptionListLabel.innerHTML = multipleSelect.options[x].text;
						
						custom_multipleDropDownOptionList = document.createElement("div");
						custom_multipleDropDownOptionList.setAttribute("class","listing");
						custom_multipleDropDownOptionList.appendChild(custom_multipleDropDownOptionListCheckbox);
						custom_multipleDropDownOptionList.appendChild(custom_multipleDropDownOptionListLabel);
						
						
						custom_multipleDropDownOption.appendChild(custom_multipleDropDownOptionList);
						
						countAllOptions++;
					}
					}else{
						if((multipleSelect.options[x].hidden == true) || (multipleSelect.options[x].disabled == true)){
							
							selectedOptionIndex = x;
							countAllOptions++;
						}
					}
				}
			}else{
				for(x=0; x < multipleSelect.length; x++){
					let customSelectLabel;
					if(multipleSelect.options[x].selected == true){
						customSelectLabel = document.getElementById("custom_select_dropdown_option_label_"+className+"_"+x);
						customSelectLabel.innerHTML = document.getElementsByClassName(className)[0].options[x].text;
						selectedOptionIndex = x;
						countChecked++;
						countAllOptions++;
					}else{
						customSelectLabel = document.getElementById("custom_select_dropdown_option_label_"+className+"_"+x);
						customSelectLabel.innerHTML = document.getElementsByClassName(className)[0].options[x].text;
						countAllOptions++;
					}
				}
			}
			
			
		
			if(countChecked == 1){
				custom_multipleSelect.innerHTML = "";
				custom_multipleOption = document.createElement("div");
				custom_multipleOption.setAttribute("class","custom_option_"+className+" inner-div");
				custom_multipleOption.innerHTML = multipleSelect.options[selectedOptionIndex].text;
				custom_multipleSelect.appendChild(custom_multipleOption);
			}else{
				if((countChecked < 1) && ((multipleSelect.options[selectedOptionIndex].hidden == true) || (multipleSelect.options[selectedOptionIndex].disabled == true))){
					custom_multipleSelect.innerHTML = "";
					custom_multipleOption = document.createElement("div");
					custom_multipleOption.setAttribute("class","custom_option_"+className+" inner-div");
					custom_multipleOption.innerHTML = multipleSelect.options[selectedOptionIndex].text;
					custom_multipleSelect.appendChild(custom_multipleOption);
				}else{
					custom_multipleSelect.innerHTML = "";
					custom_multipleOption = document.createElement("div");
					custom_multipleOption.setAttribute("class","custom_option_"+className+" inner-div");
					custom_multipleOption.innerHTML = countChecked+" selected";
					custom_multipleSelect.appendChild(custom_multipleOption);
				}
			}
			if(countChecked > 0){
				get_custom_SelectCounter.value = countAllOptions;
			}
		}, 500);
	}else{
		custom_multipleOption = document.createElement("div");
		custom_multipleOption.setAttribute("class","custom_option_"+className+" inner-div");
		custom_multipleOption.innerHTML = "0 selected";
		custom_multipleSelect.appendChild(custom_multipleOption);
	}
	
	
}

function chooseOptionSelectTag(className, selectedIndex){
	let multipleSelect = document.getElementsByClassName(className)[0];
	let customSelectCounter = document.getElementsByClassName("custom_select_counter_"+className)[0];
	if(multipleSelect.options[selectedIndex].selected == true){
		multipleSelect.options[selectedIndex].selected = false;
	}else{
		multipleSelect.options[selectedIndex].selected = true;
	}
	
	customSelectCounter.value = 0;
}

function checkboxOptionSelectTag(className, selectedIndex){
	let multipleSelect = document.getElementsByClassName(className)[0];
	let customSelectCheckbox = document.getElementById("custom_select_dropdown_option_checkbox_"+className+"_"+selectedIndex);
	
	if(multipleSelect.options[selectedIndex].selected == true){
		customSelectCheckbox.checked = false;
	}else{
		customSelectCheckbox.checked = true;
	}
	
}


//End of Multiple select box

//Beginning of login as user 

function logAsUser(type, school_id){
	if(type === "school-admin"){
		if(confirm("Are you sure, press 'OK' to proceed to login")){
			document.getElementById("login-as-user-type-inp").value = type;
			document.getElementById("login-as-user-sch-inp").value = school_id;
			document.getElementById("login-as-user-btn").click();
		}
	}
}

//End of login as user

//Beginning of CBT Start
function isJSON(jsonText) {
	try {
		JSON.parse(jsonText);
		return true;
	} catch (e) {
		return false;
	}
}

function fetchCBTQuest(examButtonID) {
	const examButton = document.getElementById(examButtonID);
	const getExamCBTID = examButton.getAttribute("exam-cbt-id");
	
	const fetchXMLRequest = new XMLHttpRequest();
	fetchXMLRequest.open("POST", "exam-question-fetcher.php");
	fetchXMLRequest.setRequestHeader("Content-Type", "aplication/json");
	fetchXMLRequestStr = JSON.stringify({"id":""})
	fetchXMLRequest.onload = function () {
		if((fetchXMLRequest.readyState === 4) && (fetchXMLRequest.status === 200)) {
			alert(fetchXMLRequest.responseText);
		}
	}
	fetchXMLRequest.send();
}

//fetchCBTQuest();

let getAllQuestionsObjArrDetails = "";
let cbtExamIdentifier = "";
function proceedCBTExamButton(examButtonID) {
	if(confirm("Are You Sure You Want To Proceed?")){
		
		//Remove CBT Start Page
		const cbtStartpageDivArr = document.getElementsByClassName("cbt-start-page-div");
		if(cbtStartpageDivArr.length > 0){
			for(let x = 0; x < cbtStartpageDivArr.length; x++){
				cbtStartpageDivArr[x].remove();
			}
		}

		const examButton = document.getElementById(examButtonID);
		const getExamSchoolLogo = examButton.getAttribute("school-logo");
		const getExamStudentImage = examButton.getAttribute("student-image");
		const getExamSchoolName = examButton.getAttribute("school-name");
		const getExamStudentName = examButton.getAttribute("student-name");
		const getExamCBTID = examButton.getAttribute("exam-cbt-id");
		const getExamType = examButton.getAttribute("exam-type");
		const getDecodePhase1 = decodeURIComponent(examButton.getAttribute("cbt-identifier"));
		const getDecodePhase2 = atob(getDecodePhase1);
		const getDecodePhase3 = decodeURIComponent(getDecodePhase2);
		const getDecodePhase4 = atob(getDecodePhase3);
		const getExamJSON = getDecodePhase4;

		if(isJSON(getExamJSON) == true){
			//CBT Started
			const fetchXMLRequest = new XMLHttpRequest();
			fetchXMLRequest.open("POST", "cbt-started.php");
			fetchXMLRequest.setRequestHeader("Content-Type", "aplication/json");
			fetchXMLRequestStr = JSON.stringify({"id": getExamCBTID});
			fetchXMLRequest.send(fetchXMLRequestStr);
			//CBT Started End

			const examJSONParse = JSON.parse(getExamJSON);
			getAllQuestionsObjArrDetails = examJSONParse;
			cbtExamIdentifier = getExamCBTID;

			createExamContainerDiv = document.createElement("div");
			createExamContainerDiv.id = "exam-container";
			createExamContainerDiv.className = "mobile-width-90 system-width-90";
			createExamContainerDiv.style = "display: block; text-align: center; margin: 50px 0 50px 0;";
			
			createExamInfoDiv = document.createElement("div");
			createExamInfoDiv.id = "";
			createExamInfoDiv.className = "mobile-width-100 system-width-100";
			createExamInfoDiv.style = "display: flex; flex-direction: row; justify-content: center; text-align: center; margin: auto;";
			
			createSchoolLogo = document.createElement("img");
			createSchoolLogo.src = getExamSchoolLogo;
			createSchoolLogo.alt = "School Logo";
			createSchoolLogo.className = "bg-5 mobile-width-20 system-width-15";
			createSchoolLogo.style = "min-height: auto; max-height: 150px; object-fit: cover;";
			
			createStudentImage = document.createElement("img");
			createStudentImage.src = getExamStudentImage;
			createStudentImage.alt = "Student Image";
			createStudentImage.className = "bg-5 mobile-width-20 system-width-15";
			createStudentImage.style = "min-height: auto; max-height: 150px; object-fit: cover;";
			
			createExamHeader = document.createElement("span");
			createExamHeader.className = "mobile-font-size-16 system-font-size-22"
			createExamHeader.style = "display: block; color: olivedrab; font-weight: bold; margin: 10px 0 10px 0;";
			createExamHeader.innerHTML = getExamSchoolName.toUpperCase() + "<br/>";
			createExamHeader.innerHTML += getExamType.toUpperCase() + " QUESTIONS";

			createExamHeaderDiv = document.createElement("div");
			createExamHeaderDiv.className = "mobile-width-90 system-width-70";
			createExamHeaderDiv.style = "display: block; text-align: center; margin: auto auto 5% auto;";
			
			
			createExamHeaderDivSpan1 = document.createElement("span");
			createExamHeaderDivSpan1.id = "";
			createExamHeaderDivSpan1.className = "mobile-font-size-16 system-font-size-18";
			createExamHeaderDivSpan1.style = "display: block; color: olivedrab; margin: auto auto 2% auto; text-align: left;";
			createExamHeaderDivSpan1.innerHTML = "<strong>Fullname:</strong> ";
			createExamHeaderDivSpan1.innerHTML += getExamStudentName;
			
			createExamHeaderDivSpan2 = document.createElement("span");
			createExamHeaderDivSpan2.id = "jamb-exam";
			createExamHeaderDivSpan2.className = "mobile-font-size-16 system-font-size-18";
			createExamHeaderDivSpan2.style = "display: block; color: olivedrab; margin: auto auto 2% auto; text-align: left;";

			createExamHeaderDivSpan3 = document.createElement("span");
			createExamHeaderDivSpan3.id = "exam-counter";
			createExamHeaderDivSpan3.className = "mobile-font-size-16 system-font-size-18";
			createExamHeaderDivSpan3.style = "display: block; color: olivedrab; margin: auto auto 2% auto; text-align: left;";

			createExamHeaderDivSpan4 = document.createElement("span");
			createExamHeaderDivSpan4.id = "exam-time";
			createExamHeaderDivSpan4.className = "mobile-font-size-16 system-font-size-18";
			createExamHeaderDivSpan4.style = "display: inline-block; color: olivedrab; margin: auto auto 2% auto; float: left; clear: left;";

			createExamSubmitButton = document.createElement("button");
			createExamSubmitButton.id = "submit-btn";
			createExamSubmitButton.type = "button";
			createExamSubmitButton.setAttribute("onclick", "submitExam()");
			createExamSubmitButton.className = "mobile-font-size-14 system-font-size-18";
			createExamSubmitButton.style = "cursor: pointer; display: inline-block; width: auto; height: auto; text-align: center; padding: 1% 2%; border: 2px solid olivedrab; color: antiquewhite; background-color: olivedrab; float: right; clear: right; border-radius: 5px; margin: 0 0 2% 5%; outline: none;";
			createExamSubmitButton.innerHTML = "Submit";
			
			createExamQuestionContainerDiv = document.createElement("div");
			createExamQuestionContainerDiv.id = "question-container";
			createExamQuestionContainerDiv.className = "mobile-width-90 system-width-70 mobile-font-size-16 system-font-size-20";
			createExamQuestionContainerDiv.style = "display: block; text-align: left; margin: auto auto 5% auto;";
			
			createExamPrevNextDiv = document.createElement("div");
			createExamPrevNextDiv.id = "";
			createExamPrevNextDiv.className = "mobile-width-90 system-width-70";
			createExamPrevNextDiv.style = "display: block; justify-content: center; text-align: center; margin: auto;";
			
			createExamPrevButton = document.createElement("button");
			createExamPrevButton.id = "";
			createExamPrevButton.type = "button";
			createExamPrevButton.setAttribute("onclick", "prevButton()");
			createExamPrevButton.className = "mobile-font-size-14 system-font-size-18";
			createExamPrevButton.style = "cursor: pointer; font-weight: bolder; text-align: center; float: left; clear: left; width: auto; margin: 0; padding: 1% 2%; border: 2px solid olivedrab; color: antiquewhite; background-color: olivedrab; border-radius: 5px; outline: none;";
			createExamPrevButton.innerHTML = "<< Prev";
			
			createExamNextButton = document.createElement("button");
			createExamNextButton.id = "";
			createExamNextButton.type = "button";
			createExamNextButton.setAttribute("onclick", "nextButton()");
			createExamNextButton.className = "mobile-font-size-14 system-font-size-18";
			createExamNextButton.style = "cursor: pointer; font-weight: bolder; text-align: center; float: right; clear: right; width: auto; margin: 0; padding: 1% 2%; border: 2px solid olivedrab; color: antiquewhite; background-color: olivedrab; border-radius: 5px; outline: none;";
			createExamNextButton.innerHTML = "Next >>";
			
			createExamMsgSpan = document.createElement("span");
			createExamMsgSpan.id = "jamb-msg";
			createExamMsgSpan.style = "display: block; color: olivedrab;";

			createExamBreakLine = document.createElement("br");
			
			createExamInfoDiv.appendChild(createSchoolLogo);
			createExamInfoDiv.appendChild(createStudentImage);
			createExamHeaderDiv.appendChild(createExamHeaderDivSpan1);
			createExamHeaderDiv.appendChild(createExamHeaderDivSpan2);
			createExamHeaderDiv.appendChild(createExamHeaderDivSpan3);
			createExamHeaderDiv.appendChild(createExamHeaderDivSpan4);
			createExamHeaderDiv.appendChild(createExamSubmitButton);
			createExamPrevNextDiv.appendChild(createExamPrevButton);
			createExamPrevNextDiv.appendChild(createExamNextButton);
			
			createExamContainerDiv.appendChild(createExamInfoDiv);
			createExamContainerDiv.appendChild(createExamHeader);
			createExamContainerDiv.appendChild(createExamHeaderDiv);
			createExamContainerDiv.appendChild(createExamBreakLine);
			createExamContainerDiv.appendChild(createExamQuestionContainerDiv);
			createExamContainerDiv.appendChild(createExamPrevNextDiv);
			createExamContainerDiv.appendChild(createExamMsgSpan);

			createExamScript = document.createElement("script");
			createExamScript.src = "/js/cbt-exam.js";
			createExamScript.setAttribute("defer", "");
			document.body.appendChild(createExamScript);
			
			document.getElementsByClassName("cbt-test-popup-div")[0].appendChild(createExamContainerDiv);
		}
	}
}

function closeExamPopUpDiv() {
	if(confirm("Are You Sure You Want To Close This Page?")){
		const popUpDivArr = document.getElementsByClassName("cbt-test-popup-div");
		if(popUpDivArr.length > 0){
			for(let x = 0; x < popUpDivArr.length; x++){
				popUpDivArr[x].remove();
			}
		}
	}
}

function closeAfterSubmissionExamPopUpDiv() {
	setTimeout(() => {
		window.location.href = window.location.href;
	}, 5000);
}

function startCBTExam(examButtonHTML) {
	if(confirm("Are You Sure You Want To Start This Exam?")){
		const examButton = examButtonHTML;
		const getExamID = examButton.getAttribute("id");
		const getDecodePhase1 = decodeURIComponent(examButton.getAttribute("cbt-identifier"));
		const getDecodePhase2 = atob(getDecodePhase1);
		const getDecodePhase3 = decodeURIComponent(getDecodePhase2);
		const getDecodePhase4 = atob(getDecodePhase3);
		const getExamJSON = getDecodePhase4;

			if(isJSON(getExamJSON) == true){
				const examJSONParse = JSON.parse(getExamJSON);
				createExamPopupDivContainer = document.createElement("div");
				createExamPopupDivContainer.id = "";
				createExamPopupDivContainer.className = "cbt-test-popup-div bg-2 container-box mobile-width-100 system-width-100";
				createExamPopupDivContainer.style = "display: flex; justify-content: center; align-items: center; margin: 0 0 0 -8px; text-align: center; z-index: 10; top: 0px; position: fixed; height: 100vh; overflow: auto;";

				createExamStartPage = document.createElement("div");
				createExamStartPage.id = "";
				createExamStartPage.className = "cbt-start-page-div bg-7 container-box mobile-width-50 system-width-50";
				createExamStartPage.style = "display: block; text-align: center; margin: auto; padding: 15px 15px; border-radius: 10px;";

				createExamStartPageSpan = document.createElement("span");
				createExamStartPageSpan.id = "";
				createExamStartPageSpan.className = "cbt-start-page-span color-6 bg-3 container-box mobile-width-100 system-width-100 mobile-font-size-14 system-font-size-16";
				createExamStartPageSpan.style = "display: block; text-align: left; margin: 0 0 10px 0;";
				createExamStartPageSpan.innerHTML = "Subject: <big><strong>" + examJSONParse["exams"].join(", ").toUpperCase() + "</strong></big><br/>";
				createExamStartPageSpan.innerHTML += "Duration: <big><strong>" + examJSONParse["time"] + "</strong></big>, ";
				createExamStartPageSpan.innerHTML += "Questions: <big><strong>" + examJSONParse["examAttempts"] + "</strong></big><br/><br/>";
				createExamStartPageSpan.innerHTML += "Follow exam instructions carefully. If ussure, ask the exam invigilator for clarification. Once you start the exam it can not be revert back, are you sure you want to start this exam? if yes click PROCEED";
				createExamStartPageSpan.innerHTML += "<br/>";

				createProceedButton = document.createElement("button");
				createProceedButton.id = "";
				createProceedButton.className = "color-2 bg-4";
				createProceedButton.style = "cursor: pointer; font-weight: bold; background-color: ; border-radius: 15px; padding: 7px 7px; margin: 2px;";
				createProceedButton.innerHTML = "Proceed";
				createProceedButton.setAttribute("onclick", "proceedCBTExamButton('" + getExamID + "')");

				createCloseButton = document.createElement("button");
				createCloseButton.id = "";
				createCloseButton.className = "color-2";
				createCloseButton.style = "cursor: pointer; font-weight: bold; background-color: red; border-radius: 15px; padding: 7px 7px; margin: 2px;";
				createCloseButton.innerHTML = "Close Page";
				createCloseButton.setAttribute("onclick", "closeExamPopUpDiv()");

				createExamStartPage.appendChild(createExamStartPageSpan);
				createExamStartPage.appendChild(createProceedButton);
				createExamStartPage.appendChild(createCloseButton);
				createExamPopupDivContainer.appendChild(createExamStartPage);
				if(document.getElementsByClassName("cbt-test-popup-div").length === 0){
					document.body.appendChild(createExamPopupDivContainer);
				}else{
					document.getElementsByClassName("cbt-test-popup-div")[0].remove();
					document.body.appendChild(createExamPopupDivContainer);
				}
			}else{
				alert("Invalid Exam Details");
			}
	}else{
		alert("Operation Cancelled");
	}
}

function smsPaymentCallBackRecord(school_id, amount, payment_ref){
	const smsPaymentHttpRequest = new XMLHttpRequest();
	smsPaymentHttpRequest.open("POST","./sms-payment-record.php");
	smsPaymentHttpRequest.setRequestHeader("Content-Type","application/json");
	const smsPaymentHttpRequestBody = JSON.stringify({sch_no: school_id, amount: amount, ref: payment_ref});
	smsPaymentHttpRequest.onload = function(){
		if((smsPaymentHttpRequest.readyState == 4) && (smsPaymentHttpRequest.status == 200)){
		const smsPaymentResponse = JSON.parse(smsPaymentHttpRequest.responseText)["response"];
			if(smsPaymentResponse == 1){
				alert("Payment successful and wallet credited.");
			}
		}else{
			alert(smsPaymentHttpRequest.status);
		}
	}
	smsPaymentHttpRequest.send(smsPaymentHttpRequestBody);
}