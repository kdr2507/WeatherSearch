src = "/weather.js";

var map;

var latitude = null; //위도
var longitude = null; //경도
var dfs_xy = null; //기상청 위도경도
var markerCheck = false;
var markers = null;

if ("geolocation" in navigator) {
  function initMap() {
    //내위치 확인 여부를 묻는다.(권한 설정)
    var watchID = navigator.geolocation.getCurrentPosition(function(position) {
      //지도의 초기 위치 및 기본 정보 입력, 생성
      //지도의 정보
      map = new google.maps.Map(document.getElementById("map"), {
        center: {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        },
        zoom: 10,
        mapTypeId: "roadmap",
        zoomControl: false,
        scaleControl: true
      });

      //------------------ 검색 -------------------------------------
      // 검색상자를 만들어 UI요소를 연결
      var input = document.getElementById("pac-input");
      var searchBox = new google.maps.places.SearchBox(input);

      //검색창을 원하는 위치로 이동하기
      //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // 검색 결과를 현재 지도의 뷰 포트 쪽으로 움직이게 함.
      map.addListener("bounds_changed", function() {
        searchBox.setBounds(map.getBounds());
      });

      searchBox.addListener("places_changed", function() {
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();

        if (places.length == 0) {
          return;
        }

        //검색한 곳에 마커 표시
        if (markerCheck == false) {
          markerCheck = true;
          markers = new google.maps.Marker({
            position: places[0].geometry.location,
            map: map
          });

          if (places[0].geometry.viewport) {
            bounds.union(places[0].geometry.viewport);
          } else {
            bounds.extend(places[0].geometry.location);
          }

          map.fitBounds(bounds);
          latitude = places[0].geometry.location.lat();
          longitude = places[0].geometry.location.lng();

          // dfs_xy = dfs_xy_conv("toXY", latitude, longitude);

          //서버로 데이터 전송
          sendLocation(latitude, longitude);
        } else if (markerCheck == true) {
          markerCheck = false;
          markers.setMap(null);
        }
      });

      //----------------- 클릭한 장소에 좌표 추출 및 마커 표시 --------------------------------
      //지도를 클릭했을때 클릭한 장소의 좌표값
      google.maps.event.addListener(map, "click", function(event) {
        //클릭한 곳에 마커 표시
        if (markerCheck == false) {
          markerCheck = true;
          markers = new google.maps.Marker({
            position: event.latLng,
            map: map
          });

          latitude = event.latLng.lat();
          longitude = event.latLng.lng();

          //기상청 좌표값
          // dfs_xy = dfs_xy_conv("toXY", latitude, longitude);

          //서버로 데이터 전송
          sendLocation(latitude, longitude);
        } else if (markerCheck == true) {
          markerCheck = false;
          markers.setMap(null);
        }
      });

      /*
      //마우스 커서의 위치에 따른 좌표값 출력
      google.maps.event.addListener(map, "mousemove", function(event) {
        document.getElementById("latmoved").innerHTML = event.latLng.lat();
        document.getElementById("longmoved").innerHTML = event.latLng.lng();
      });
      */
    });
  }
} else {
  /* 지오로케이션 사용 불가능 */
}

//서버로 데이터 전송
function sendLocation(latitude, longitude) {
  var xml = new XMLHttpRequest();

  var url = "/weather.php";

  var language = document.getElementById("country");

  xml.open("post", url, true);
  xml.setRequestHeader(
    "Content-type",
    "application/x-www-form-urlencoded; charset=UTF-8"
    //"application/json"
  );
  xml.send(
    "latitude=" +
      latitude +
      "&longitude=" +
      longitude +
      "&language=" +
      language.options[language.selectedIndex].value
  );

  xml.onreadystatechange = function() {
    if (xml.readyState == 4 && xml.status == 200) {
      var weatherInfo = document.getElementById("weatherInfo");
      delete_table();

      //console.log(xml.responseText);
      var result = xml.responseText;
      weatherInfo.innerHTML = result;
    }
  };
}

//테이블 삭제
function delete_table() {
  var weatherInfo = document.getElementById("weatherInfo");

  while (weatherInfo.children.length > 0) {
    weatherInfo.removeChild(weatherInfo.firstChild);
  }
}
