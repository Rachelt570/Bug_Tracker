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

	var JSON_Data = JSON.parse(await getFriendRequests(sessionUsername));
	console.log(JSON_Data);
});