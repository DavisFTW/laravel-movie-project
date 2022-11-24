console.log('x');
const settings = {
	"async": true,
	"crossDomain": true,
	"url": "https://movies-app1.p.rapidapi.com/api/movies",
	"method": "GET",
	"headers": {
		"X-RapidAPI-Key": "ce57f65596msh6dc04e854ba1d77p1e556djsn4069d16d8b62",
		"X-RapidAPI-Host": "movies-app1.p.rapidapi.com"
	}
};

$.ajax(settings).done(function (response) {
	console.log(response);
});
