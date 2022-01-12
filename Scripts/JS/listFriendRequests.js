
$(document).ready(async function()
{
	var sessionData = await getSessionData();
	var friendRequestIDs = [];
	friendRequestIDs = await getFriendRequests(sessionData[0]);
	var friendRequestNames = [];
	for(let i = 0; i < friendRequestIDs.length; i++)
	{
		friendRequestNames.push(await getUsernameFromUID(friendRequestIDs[i]));
		friendRequestNames[i] = friendRequestNames[i].replaceAll('\"', '');
	}
	displayRequests(friendRequestNames);
});

function displayRequests(friendRequestNames)
{
	for(let i = 0; i < friendRequestNames.length; i++)
	{
		displayRequest(friendRequestNames[i]);
	}
	return;
}
function displayRequest(friendRequest)
{
	var requestList = $(FriendRequests);
	$(requestList).append("<li> <input type ='button'> </input> <input type = 'button'> </input>" + friendRequest + "</li>");

}