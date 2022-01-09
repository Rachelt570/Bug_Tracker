$(document).ready(async function()
{
	var sessionUID;
	var sessionUsername;
	var sessionEmail;
	async function getSessionVariables()
	{
		async function callPHPFunction(func)
		{
			var fData = { function : func};
			var result;
			return new Promise((resolve, reject) => {
				$.ajax({
					type: "POST",
					data: fData,
					url: "Scripts/PHP/Helper.inc.php",
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
		let fData = { function : "getFriendRequests" };
		return new Promise((resolve, reject) => { 
			$.ajax ({
				type: "POST",
				data: fData,
				url: "Scripts/PHP/GetFriendRequests.inc.php",
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
	var JSONData = JSON.parse(await getFriendRequests(sessionUsername));
	console.log(sessionUID);
	console.log(sessionUsername);
	console.log(sessionEmail);
	console.log(JSONData);
});