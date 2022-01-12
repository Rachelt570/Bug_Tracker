async function callFunctionFromPHP(functionName, parameters)
{
	var fData = { function: functionName, parameters : parameters };
	return new Promise((resolve, reject) => {
		$.ajax({
			type: "POST",
			data: fData, 
			url: "Scripts/PHP/AjaxHelper.inc.php",
			success: function(data) {
				resolve(data);
			},
			error: function(error) {
				reject(error);
			}
		})
	})
}
async function getUsernameFromUID(UID)
{
	return await callFunctionFromPHP("echoUsernameFromUID", UID);
}
async function getEmailFromUID(UID) 
{
	return await callFunctionFromPHP("echoEmailFromUID", UID);
}
async function getUIDFromUsername(Username)
{
	return await callFunctionFromPHP("echoUIDFromUsername", Username);
}
async function getUIDFromEmail(Email)
{
	return await callFunctionFromPHP("echoUIDFromEmail", Email);
}
async function getSessionData()
{
	var sessionData = [];
	sessionData = JSON.parse(await callFunctionFromPHP("echoSessionData", ""));
	return sessionData;
}
async function getSessionUID()
{
	return await callFunctionFromPHP("echoSessionUID", "");
}
async function getSessionUsername() 
{
	return await callFunctionFromPHP("echoSessionUsername", "");
}
async function getSessionEmail()
{
	return await callFunctionFromPHP("echoSessionEmail", "");
}
async function getFriendRequests(UID)
{
	var friendRequests = [];
	friendRequests = JSON.parse(await callFunctionFromPHP("echoFriendRequests", UID));
	return friendRequests;
}