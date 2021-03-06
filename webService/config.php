<!DOCTYPE html>
<html lang="en">
<title>House cam</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
  body,
  h1,
  h2,
  h3,
  h4,
  h5 {
    font-family: "Poppins", sans-serif
  }

  body {
    font-size: 16px;
  }

  .w3-half img {
    margin-bottom: -6px;
    margin-top: 16px;
    opacity: 0.8;
    cursor: pointer
  }

  .w3-half img:hover {
    opacity: 1
  }
</style>

<body>

  <!-- Sidebar/menu -->
  <nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
      <h3 class="w3-padding-64"><b>House<br>Cam</b></h3>
    </div>
    <div class="w3-bar-block">
      <a href="/" onclick="w3_close()" class="w3-bar-item w3-button  w3-hover-white">Home</a>
      <a href="/live.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Live</a>
      
      <a href="/motion.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Motion</a>
      <a href="/config.php" onclick="w3_close()" class="w3-bar-item w3-white w3-button w3-hover-white">Settings</a>
    </div>
  </nav>

  <!-- Top menu on small screens -->
  <header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
    <span>House Cam</span>
  </header>

  <!-- Overlay effect when opening sidebar on small screens -->
  <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

  <!-- !PAGE CONTENT! -->
  <div class="w3-main" style="margin-left:340px;margin-right:40px">

    <!-- Header -->
    <div class="w3-container" style="margin-top:80px" id="showcase">
      <h1 class="w3-jumbo"><b>Settings</b></h1>
      <hr style="width:50px;border:5px solid red" class="w3-round">
    </div>

    <!-- Photo grid (modal) -->
    <div class="w3-row-padding" id="app">


      <div class="form-group">
        <label>Name</label>
        <input class="form-control" v-model="name">
      </div>
      <div class="form-group">
        <label>Connection</label>
        <input class="form-control" v-model="connection">
      </div>
      <div class="form-group">
        <label>FPS</label>
        <input class="form-control" v-model.number="fps">
      </div>

      <div class="form-group">
        <label>Blur Amount</label>
        <input class="form-control" v-model.number="blur">
      </div>
      <div class="form-group">
        <label>Box Jump (How far should a box jump before it's ignored)</label>
        <input class="form-control" v-model.number="boxJump">
      </div>
      <div class="form-group">
        <label>Debug (Add extra information to capture)</label>
        <input class="form-control" type="checkbox" v-model="debug">
      </div>
      <div class="form-group">
        <label>Buffer Before</label>
        <input class="form-control" v-model.number="bufferBefore">
      </div>
      <div class="form-group">
        <label>Buffer After</label>
        <input class="form-control" v-model.number="bufferAfter">
      </div>
      <div class="form-group">
        <label>Refresh background after </label>
        <input class="form-control" v-model.number="refreshCount">
      </div>

      <div class="form-group">
        <label>Small movement size</label>
        <input class="form-control" v-model.number="smallMove">
      </div>

      <h3>Zones</h3>

      <img v-bind:src="vid" width="500px" v-on:click="zone" id="zo"></img>


      <div v-for="(a,index) in area" class="row">
        <div class="col">
          <label>y1</label>
          <input class="form-control" v-model.number="a[0]">
        </div>
        <div class="col">
          <label>y2</label>
          <input class="form-control" v-model.number="a[1]">
        </div>
        <div class="col">
          <label>x1</label>
          <input class="form-control" v-model.number="a[2]">
        </div>
        <div class="col">
          <label>x2</label>
          <input class="form-control" v-model.number="a[3]">
        </div>
        <div class="col">
          <label>Amount</label>
          <input class="form-control" v-model.number="amount[index]">
        </div>
        <div class="col">
          <label>Threshold</label>
          <input class="form-control" v-model.number="threshold[index]">
        </div>
        <div class="col">
          <label>Min count</label>
          <input class="form-control" v-model.number="mincount[index]">
        </div>
        <div class="col">
          <button class="w3-button w3-red" v-on:click="deleteZone(index)">Delete</button>
        </div>


      </div>

      <div class="form-group">
        <label>Active</label>
        <input type="checkbox" v-model="active">
      </div>

      <input class="btn btn-primary" type="submit" value="Update" v-on:click="save">



    </div>


    <!-- End page content -->
  </div>

  <!-- W3.CSS Container -->
  <div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px">
    <p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p>
  </div>

  <script>
    // Script to open and close sidebar
    function w3_open() {
      document.getElementById("mySidebar").style.display = "block";
      document.getElementById("myOverlay").style.display = "block";
    }

    function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
      document.getElementById("myOverlay").style.display = "none";
    }

    // Modal Image Gallery
    function onClick(element) {
      document.getElementById("img01").src = element.src;
      document.getElementById("modal01").style.display = "block";
      var captionText = document.getElementById("caption");
      captionText.innerHTML = element.alt;
    }
  </script>


  <script>
    var app = new Vue({
      el: '#app',
      data: {
        name: '',
        connection: '',
        fps: 5,
        area: [],
        amount: [],
        threshold: [],
        active: true,
        mincount: [],
        vid: "",
        newZone: true,
        smallMove: 20,
        blur: 5,
        boxJump: 20,
        debug: true,
        bufferBefore: 10,
        bufferAfter: 10,
        refreshCount: 5,
      },
      mounted() {
        axios
          .get("http://<?php echo $_SERVER['HTTP_HOST']; ?>:8000/config")
          .then(response => {
            this.name = response.data.Name;
            this.connection = response.data.Connection;
            this.fps = response.data.FPS;
            this.blur = response.data.Blur;
            this.boxJump = response.data.BoxJump;
            this.debug = response.data.Debug;
            this.bufferBefore = response.data.BufferBefore;
            this.bufferAfter = response.data.BufferAfter;
            this.refreshCount = response.data.NoMoveRefreshCount;
            this.smallMove = response.data.SmallMove;

            if (response.data.Area != null) {
              this.area = response.data.Area;
            }
            if (response.data.Amount != null) {
              this.amount = response.data.Amount;
            }
            if (response.data.Threshold != null) {
              this.threshold = response.data.Threshold;
            }
            if (response.data.MinCount != null) {
              this.mincount = response.data.MinCount;
            }
            this.active = response.data.Motion;
            this.displayCamera();
          })
          .catch(response => {
            console.log("Error " + response);
          });
      },
      methods: {
        displayCamera() {
          var socket = new WebSocket("ws://<?php echo $_SERVER['HTTP_HOST']; ?>:8000/mobilestream/" + encodeURI(this.name))
          // Log errors
          socket.onclose = function(error) {
            vid = "";
          };
          let self = this;
          socket.onmessage = function(event) {
            decoded = atob(event.data)
            self.vid = "data:image/jpg;base64, " + event.data;
          }
        },
        zone(e) {
          var b = this.$el.getBoundingClientRect()
          var i = document.getElementById("zo");
          var x = e.clientX - b.left;
          var y = e.clientY - b.top - i.height;
          //Get ratio, then find real x value.

          x = Math.round(x * (i.naturalWidth / i.width))
          y = Math.round(y * (i.naturalHeight / i.height))
          console.log("x " + x + "y " + y)
          if (this.newZone) {
            this.amount.push(50);
            this.mincount.push(5);
            this.threshold.push(15);
            this.area.push([y, 0, x, 0]);
            this.newZone = false;
          } else {
            v = this.area[this.area.length - 1]
            v[1] = y;
            v[3] = x;
            this.newZone = true;
          }
        },
        deleteZone(index) {
          this.area.splice(index, 1);
          this.threshold.splice(index, 1);
          this.mincount.splice(index, 1);
          this.amount.splice(index, 1);
        },
        save: function() {
          axios
            .post("http://<?php echo $_SERVER['HTTP_HOST']; ?>:8000/config", {
              Name: this.name,
              Connection: this.connection,
              FPS: this.fps,
              Area: this.area,
              Amount: this.amount,
              Threshold: this.threshold,
              MinCount: this.mincount,
              Motion: this.active,
              Blur: this.blur,
              BoxJump: this.boxJump,
              Debug: this.debug,
              BufferBefore: this.bufferBefore,
              BufferAfter: this.bufferAfter,
              NoMoveRefreshCount: this.refreshCount,
              SmallMove: this.smallMove,
            })
            .then(response => {
              alert("Saved");
            })
            .catch(response => {
              alert("Failed to save");
            });
        },
      }
    })
  </script>

</body>

</html>