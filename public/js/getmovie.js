// console.log('x');  

// var popular_movie_status = false; // is this required ?
// var array = [];

// const popular_movie_settings = {
// 	"async": true,
// 	"crossDomain": true,
// 	"url": "https://imdb8.p.rapidapi.com/title/v2/get-popular-movies-by-genre?genre=action&limit=20",
// 	"method": "GET",
// 	"headers": {
// 		"X-RapidAPI-Key": "ce57f65596msh6dc04e854ba1d77p1e556djsn4069d16d8b62",
// 		"X-RapidAPI-Host": "imdb8.p.rapidapi.com"
// 	}
// };


// $.ajax(popular_movie_settings).done(function (response) {
// 	for (let index = 0; index < 20; index++) {
// 		let temp = response[index].replace("/title/", "");
// 		let curr = temp.replace("/", "");
// 		array.push(curr);
// 	}

// 	popular_movie_status = true;
// });

// if(popular_movie_status){
// }