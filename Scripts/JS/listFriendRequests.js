async function getUserFromUID(UID)
	{
		var fData = { function: 'echoUsernameFromUID', parameters: UID };
		return new Promise((resolve, reject) => {
			$.ajax({
				type: "POST",
				data: fData,
				url: "Scripts/PHP/AjaxHelper.inc.php",
				success: function(data) {
					resolve(data);
				},
				error: function(error){
					reject(error);
				}
			})
		})
	}
function displayRequestFromUsers(Users)
{
	for(let i = 0; i < Users.length; i++)
	{
		var str = Users[i];
		console.log(str);
		console.log(typeof(str));
		str = str.replaceAll('\"','');
		str = str.replaceAll('[', '');
		str = str.replaceAll(']', '');
		displayRequestFromUser(str);
	}
}
function displayRequestFromUser(User)
{
	$("#FriendRequests").append("<li>" + User + "</li> <input type ='button' value = 'Accept'> </input>  <input type = 'button' value = 'Decline'> </input>");
}

$(document).ready(async function()
{
	var sessionUID;
	var sessionUsername;
	var sessionEmail;
	async function getSessionVariables()
	{
		async function callPHPFunction(func)
		{
			var fData = { function : func };
			var result;
			return new Promise((resolve, reject) => {
				$.ajax({
					type: "POST",
					data: fData,
					url: "Scripts/PHP/AjaxHelper.inc.php",
					success: function(data)
					{
						resolve(data);
					},
					error: function(error)
					{
						reject(error);
					},
				})
			})
		};
		sessionUID = await(callPHPFunction("echoSessionUID"));
		sessionUsername = await(callPHPFunction("echoSessionUsername"));
		sessionEmail = await(callPHPFunction("echoSessionEmail"));

	};
	async function getFriendRequests(user)
	{
		var fData = { GetFriendRequests : "0" };
		return new Promise((resolve, reject) => { 
			$.ajax ({
				type: "POST",
				data: fData,
				url: "Scripts/PHP/FriendManagement.inc.php",
				success: function(data){
					resolve(data);
				},
				error: function(error) 
				{
					reject(error);
				},
			})
		})
	};

	await getSessionVariables();

	var Parsed_Data = JSON.parse(await getFriendRequests(sessionUsername));
	var Users_Array = [];
	for(let i = 0; i < Parsed_Data.length; i++)
	{
		Users_Array.push(await getUserFromUID(Parsed_Data[i]));
	}
	displayRequestFromUsers(Users_Array);
});