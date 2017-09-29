//BEGIN FUNCTIONS SIDEBAR

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav()
{
    document.getElementById("sidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav()
{
    document.getElementById("sidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

function changeState()
{
	if(document.getElementById("sidenav").style.width === "0px")
		openNav();
	else
		closeNav();
}

// END FUNCTIONS SIDEBAR
// BEGIN FUNCTIONS DELETION

function deletionSelectionState()
{
	let allTrue = true;
	let allFalse = true;

	let elems = document.getElementsByName('selectSingle[]');

	for(let i = 0; i < elems.length; i++)
	{
		if(elems[i].checked)
			allFalse = false;
		else
			allTrue = false;
	}

	disableDeleteAll(false);
	if(!allTrue && !allFalse)
		document.getElementById('selectAll').indeterminate = true;
	else
	{
		document.getElementById('selectAll').indeterminate = false;
		if(allTrue)
			document.getElementById('selectAll').checked = true;
		else
		{
			document.getElementById('selectAll').checked = false;
			disableDeleteAll(true);
		}
	}
}

function deletionSelectOrUnselectAll()
{
	let elems = document.getElementsByName('selectSingle[]');
	let cbAll = document.getElementById('selectAll');

	if(cbAll.indeterminate || !cbAll.checked)
	{
		for(let i = 0; i < elems.length; i++)
			elems[i].checked = false;

		disableDeleteAll(true);
	}
	else
	{
		for(let i = 0; i < elems.length; i++)
			elems[i].checked = true;

		disableDeleteAll(false);
	}
}

function disableDeleteAll(doEnable)
{
	document.getElementById('deleteSelected').disabled = doEnable;
}

function deleteSelection(elementType)
{
	let elems = document.getElementsByName('selectSingle[]');
	let tab = [];
	for(let i = 0; i < elems.length; i++)
		if(elems[i].checked)
			tab.push(elems[i].value);

	$.post('api_delete_' + elementType + '_FromDB.php', {ids: tab}, function (data, status){
		if(data === 'success')
			location.reload();
		else
			alert("Une erreur est survenue : " + data);
	});
}

function deleteArticleFromDB(mid, mname)
{
	$.post('api_deleteArticleFromDB.php', {id: mid, name: mname}, function (data, status){
		if(data === 'success')
			location.reload();
		else
			alert("Une erreur est survenue : " + data);
	});
}

function deleteStoneFromDB(mid, mname)
{
	$.post('api_deleteStoneFromDB.php', {id: mid, name: mname}, function (data, status){
		if(data === 'success')
			location.reload();
		else
			alert("Une erreur est survenue : " + data);
	});
}

function deleteUserFromDB(mmail, musername)
{
	$.post('api_deleteUserFromDB.php', {mail: mmail, username: musername}, function (data, status){
		if(data === 'success')
			location.reload();
		else
			alert("Une erreur est survenue : " + data);
	});
}

function deleteMeetingFromDB(mid, mname)
{
	$.post('api_deleteMeetingFromDB.php', {id: mid, name: mname}, function (data, status){
		if(data === 'success')
			location.reload();
		else
			alert("Une erreur est survenue : " + data);
	});
}

// END DELETION FUNCTIONS
// BEGIN USERS FUNCTIONS

function enableOrDisableMailConfirmation()
{
	let mail = document.getElementById('editUser_mail');
	if(mail.value === mail.defaultValue)
	{
		document.getElementById('editUser_confirm_default').disabled = true;
		document.getElementById('editUser_confirm_force').disabled = true;
	}
	else
	{
		document.getElementById('editUser_confirm_default').disabled = false;
		document.getElementById('editUser_confirm_force').disabled = false;
	}
}

// END USERS FUNCTIONS
// BEGIN GLOBAL FUNCTIONS

function indexOf(list, str)
{
	for(let i = 0; i <= list.length; i++)
		if(list[i].text === str)
			return i;

	return -1;
}

// END GLOBAL FUNCTIONS
// BEGIN FUNCTIONS TO_DELETE

function test()
{
	alert("Hello world !");
}

// END FUNCTIONS TO_DELETE
