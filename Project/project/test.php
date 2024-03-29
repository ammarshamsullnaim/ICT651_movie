<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIza*******&callback=initMap"></script>
  <style>
    #app {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }
    #map {
      height: 400px;
      margin-bottom: 20px;
    }
    #eventList ul {
      list-style: none;
      padding: 0;
    }
    #eventList li {
      border-bottom: 1px solid #ccc;
      padding: 10px;
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<body>
  <div id="app">
    <h1>Event Dashboard</h1>
    <div id="map"></div>
    <div id="eventList">
      <h2>Event List</h2>
      <ul>
        <li v-for="(event, index) in events" :key="index">
          {{ event.title }}
          <button @click="showPlace(event)">Show Place</button>
        </li>
      </ul>
    </div>
  </div>

  <script>
    new Vue({
      el: '#app',
      data: {
        map: null,
        markers: [],
        infoWindows: [],
        events: [
          { lat: 6.448889, lng: 100.278889, title: 'Mini Complex Championship - Kompleks Sukan' },
          { lat: 6.4486, lng: 100.2789, title: 'Munajat Final Exam - Masjid An-Nur' },
          { lat: 6.4492, lng: 100.2772, title: 'Program "Hati ke Hati" - Dewan Seri Semarak' },
          { lat: 6.449, lng: 100.28, title: 'Arau Got Talent - Anjung Siswa' },
          // Add more events as needed
        ],
      },
      mounted() {
        this.initMap();
        this.displayEventsOnMap();
      },
      methods: {
        initMap() {
          this.map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 6.45, lng: 100.2796 },
            zoom: 15,
          });
        },
        displayEventsOnMap() {
          for (let i = 0; i < this.events.length; i++) {
            const marker = new google.maps.Marker({
              position: { lat: this.events[i].lat, lng: this.events[i].lng },
              map: this.map,
              title: this.events[i].title,
            });

            const infoWindow = new google.maps.InfoWindow({
              content: <strong>${this.events[i].title}</strong><br>Lat: ${this.events[i].lat}, Lng: ${this.events[i].lng},
            });

            this.markers.push(marker);
            this.infoWindows.push(infoWindow);

            marker.addListener('click', () => {
              this.showPlaceInfo(i);
            });
          }
        },
        showPlace(event) {
          // Close all InfoWindows
          this.infoWindows.forEach(infoWindow => infoWindow.close());

          // Open the InfoWindow for the selected event
          this.infoWindows[this.events.indexOf(event)].open(this.map, this.markers[this.events.indexOf(event)]);
          
          // Center the map on the selected event
          this.map.setCenter(this.markers[this.events.indexOf(event)].getPosition());
        },
      },
    });
  </script>
</body>
</html>
