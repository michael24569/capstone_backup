
<?php
session_start();
require_once 'security_check.php';
checkStaffAccess();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home for Staff</title>
    <script type="text/javascript">
    window.history.forward();
    </script>
    <link rel="stylesheet" href="mapstyle.css">
    <link rel="stylesheet" href="map.css">
    <link rel="stylesheet" href="LotInfo.css">
    <link rel="stylesheet" href="stsLots.css">
    <link rel ="stylesheet" href="Paiyakan.css">
    <link rel="stylesheet" href="logoutmodal.css">
   

    <style>
#searchInput{
     padding-right: 20px; 
    box-sizing: border-box;
    width: 200px;
}
.input-group {
    display: flex;
    align-items: center;
    position: absolute;
    top: 15px;
    right: 1px;
    background-color: #fff;
    border-radius: 30px; 
    padding: 2px;
    box-shadow: 0 2px 5px #0000001a; 
}

.form-control {
    border: none;
    outline: none; 
    border-radius: 30px; 
    padding-left: 10px;
    font-size: 16px;
    background-color: transparent; 
    color: #555; 
    width: 90%; /* Start with width 0 */
}



.form-control::placeholder {
    color: #aaa; 
    font-size: 15px;
}

.btn-search {
    color: white;
    font-size: 19px;
    font-weight: bold;
    background-color: #006d39; 
    border: none; 
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.5s ease;
}

.btn-search:hover {
    background-color: #274637; 
}


    #itemPopup {
    width: 300px; 
    height: 400px; 
    }
   
.Saints {
  width: 0;
  height: 40px;
  font-size: 14px;
  border: 1px solid #ccc;
  background-color: #f9f9f9;
  border: 1px solid black;
  border-radius: 20px;
  position: fixed;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  padding: 5px 0; 
  box-shadow: 0 2px 5px #0000001a;
  z-index: 100;
  opacity: 0; 
  overflow: hidden;
  animation: fadeExpand 0.5s ease forwards;
  animation-delay: 0.1s;
}
.Saints {
  bottom: 1%;
}

/* Target 1920x1080 resolution */
@media (min-width: 1920px) and (max-height: 1080px) {
  .Saints {
    bottom: 1%;
  }
}

/* Target 1600x900 resolution */
@media (min-width: 1600px) and (max-height: 900px) and (max-width: 1920px) {
  .Saints {
    bottom: 5%;
  }
}

.narrow {
    width: 0;
  height: 40px;
  font-size: 14px;
  border: 1px solid #ccc;
  background-color: #f9f9f9;
  border: 1px solid black;
  border-radius: 20px;
  position: fixed;
  top: 70%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  padding: 5px 0; 
  box-shadow: 0 2px 5px #0000001a;
  z-index: 100;
  opacity: 0; 
  overflow: hidden;
  animation: fadeExpand 0.5s ease forwards;
  animation-delay: 0.1s;
}
.medium {
    width: 0;
  height: 40px;
  font-size: 14px;
  border: 1px solid #ccc;
  background-color: #f9f9f9;
  border: 1px solid black;
  border-radius: 20px;
  position: fixed;
  top: 69%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  padding: 5px 0; 
  box-shadow: 0 2px 5px #0000001a;
  z-index: 100;
  opacity: 0; 
  overflow: hidden;
  animation: fadeExpand 0.5s ease forwards;
  animation-delay: 0.1s;
}

.loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    background-image: url('images/s2.jpg');
    background-size: cover;
    background-position: center;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Ensure it's on top */
}

.loader .background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #ffffff1a, #ffffff00);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
    z-index: -1; 
}

.spinner {
    border: 10px solid rgba(243, 243, 243, 0.2); 
    border-top: 10px solid rgba(243, 243, 243, 0.6);
    border-radius: 50%;
    width: 100px;
    height: 100px;
    animation: spin 1s linear infinite; 
    position: relative; 
    box-shadow: 0 0 15px rgba(243, 243, 243, 0.4), 0 0 5px rgba(243, 243, 243, 0.2); 
    background: radial-gradient(circle, rgba(255, 255, 255, 0.05), rgba(0, 0, 0, 0.05)); 
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.highlight-border { 
    border: 5px solid yellow;
}
.clear-button {
    cursor: pointer;
    position: absolute;
    right: 40px; /* Adjust based on your design */
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px; /* Adjust size as needed */
    color: #aaa; /* Color of the clear button */
}

        .suggestion-box {
           position: fixed;
           top: 55px;
           right: 30px;
           border: 1px solid #ccc;
           max-height: 150px;
           overflow-y: auto;
           background-color: #fff;
           width: 200px;
           z-index: 1000;
           box-shadow: 0 2px 4px rgba(0, 0,  0.1);
           border-radius: 5px;
           display: none;
        }
        .suggestion-item {
            padding: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }

/* Resize for smaller screens */
@media (max-width: 768px) {
    .form-control {
        width: 60%;  /* Adjust width for tablets */
        font-size: 10px;
    }

    .btn-search {
        width: 10px;
        height: 10px;
    }
}

@media (max-width: 480px) {
    .form-control {
        width: 1%;  /* Adjust width for mobile */
        font-size: 5px;
    }

    .btn-search {
        width: 5px;
        height: 5px;
    }
}
    </style>

</head>

<body style="background: #071c14;" id="bg">
<div id="loader" class="loader">
        <div class="background"></div>
        <div class="spinner"></div>
    </div>
    <div class="Map" id="map">

  <div class="panel" id="imagePanel">
    <div class="panelHeader">
        Chapel
        <button class="closebtnP" id="closePanel">&times;</button>
    </div>
    <div class="SliderContaier">
        <div class="slider" id="slider">
            <div class="slide">
                <img src="paiyakan/p1.jpeg" alt="p1">
            </div>
            <div class="slide">
                <img src="paiyakan/p2.jpeg" alt="p2">
            </div>
            <div class="slide">
                <img src="paiyakan/p3.jpeg" alt="p3">
            </div>
        </div>
        <div class="sliderNav">
            <button id="prevSlide"><span class="arrow">&#9664;</span></button>
            <button id="nextSlide"><span class="arrow">&#9654;</span></button>
        </div>
    </div>
</div>
        
        <!-- appear this button when the sidebar is hide-->
      <img src="map1.png" usemap="#mymap" id="responsiveImage">
      <button class="top-left-button" onclick="toggleSidebar()">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>
<!-- Search button for the map-->
<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="Search Owner" id="searchInput" autocomplete="off">
    <span id="clearButton" class="clear-button" style="display: none;">&times;</span>
    <br>
    <button class='btn btn-search' type="button" id="searchButton">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"  style="width: 20px; height: 20px; fill: white;">
        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
    </button>
</div>
<div id="suggestions" class="suggestion-box"></div>
      
        <div class="A3" id="A3"><h3 style="color: #e9f9ef;">Apartment 3</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
          
            <div class="sideAa3" id="sideAa3"><h3 style="color: white;">Apartment 3 Side A</h3><br>

                <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>

                <button id="AA3closePopup" class="AA3closebutton">&times;</button>
                <div class="SAa3Grid" id="SAa3Grid">
        <div data-lotno="1" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">1</div>
        <div data-lotno="2" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">2</div>
        <div data-lotno="3" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">3</div>
        <div data-lotno="4" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">4</div>
        <div data-lotno="5" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">5</div>
        <div data-lotno="6" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">6</div>
        <div data-lotno="7" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">7</div>
        <div data-lotno="8" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">8</div>
        <div data-lotno="9" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">9</div>
        <div data-lotno="10" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">10</div>
        
        <div data-lotno="11" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">11</div>
        <div data-lotno="12" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">12</div>
        <div data-lotno="13" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">13</div>
        <div data-lotno="14" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">14</div>
        <div data-lotno="15" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">15</div>
        <div data-lotno="16" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">16</div>
        <div data-lotno="17" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">17</div>
        <div data-lotno="18" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">18</div>
        <div data-lotno="19" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">19</div>
        <div data-lotno="20" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">20</div>
        
        <div data-lotno="21" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">21</div>
        <div data-lotno="22" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">22</div>
        <div data-lotno="23" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">23</div>
        <div data-lotno="24" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">24</div>
        <div data-lotno="25" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">25</div>
        <div data-lotno="26" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">26</div>
        <div data-lotno="27" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">27</div>
        <div data-lotno="28" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">28</div>
        <div data-lotno="29" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">29</div>
        <div data-lotno="30" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">30</div>
        
        <div data-lotno="31" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">31</div>
        <div data-lotno="32" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">32</div>
        <div data-lotno="33" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">33</div>
        <div data-lotno="34" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">34</div>
        <div data-lotno="35" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">35</div>
        <div data-lotno="36" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">36</div>
        <div data-lotno="37" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">37</div>
        <div data-lotno="38" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">38</div>
        <div data-lotno="39" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">39</div>
        <div data-lotno="40" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">40</div>
        
        <div data-lotno="41" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">41</div>
        <div data-lotno="42" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">42</div>
        <div data-lotno="43" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">43</div>
        <div data-lotno="44" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">44</div>
        <div data-lotno="45" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">45</div>
        <div data-lotno="46" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">46</div>
        <div data-lotno="47" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">47</div>
        <div data-lotno="48" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">48</div>
        <div data-lotno="49" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">49</div>
        <div data-lotno="50" data-memsts="Apartment3" data-memlot="None" class="grid-itemA3">50</div>
        
                    
                    </div>
            </div>
            <div class="sideBa3" id="sideBa3"><h3 style="color: white;"> Apartment 3 Side B</h3><br>
                <button id="BA3closePopup" class="BA3closebutton">&times;</button>
                
                <div class="A1lgndsSA" id="legendBox">
                    <div class="legends">Legend</div>
                    <div class="legendList">
                    <div class="legendU Available"></div>
                    <span>Available slots</span>
                    </div>
                <div class="legendList">
                  <div class="legendU Unavailable"></div>
                  <span>Owned slots</span>
                </div>
              </div>
                
              <div   div class="SBa3Grid" id="SBa3Grid">
                <div data-lotno="51" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">51</div>
                <div data-lotno="52" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">52</div>
                <div data-lotno="53" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">53</div>
                <div data-lotno="54" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">54</div>
                <div data-lotno="55" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">55</div>
                <div data-lotno="56" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">56</div>
                <div data-lotno="57" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">57</div>
                <div data-lotno="58" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">58</div>
                <div data-lotno="59" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">59</div>
                <div data-lotno="60" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">60</div>
                
                <div data-lotno="61" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">61</div>
                <div data-lotno="62" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">62</div>
                <div data-lotno="63" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">63</div>
                <div data-lotno="64" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">64</div>
                <div data-lotno="65" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">65</div>
                <div data-lotno="66" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">66</div>
                <div data-lotno="67" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">67</div>
                <div data-lotno="68" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">68</div>
                <div data-lotno="69" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">69</div>
                <div data-lotno="70" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">70</div>
                
                <div data-lotno="71" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">71</div>
                <div data-lotno="72" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">72</div>
                <div data-lotno="73" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">73</div>
                <div data-lotno="74" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">74</div>
                <div data-lotno="75" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">75</div>
                <div data-lotno="76" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">76</div>
                <div data-lotno="77" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">77</div>
                <div data-lotno="78" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">78</div>
                <div data-lotno="79" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">79</div>
                <div data-lotno="80" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">80</div>
                
                <div data-lotno="81" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">81</div>
                <div data-lotno="82" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">82</div>
                <div data-lotno="83" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">83</div>
                <div data-lotno="84" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">84</div>
                <div data-lotno="85" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">85</div>
                <div data-lotno="86" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">86</div>
                <div data-lotno="87" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">87</div>
                <div data-lotno="88" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">88</div>
                <div data-lotno="89" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">89</div>
                <div data-lotno="90" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">90</div>
                
                <div data-lotno="91" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">91</div>
                <div data-lotno="92" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">92</div>
                <div data-lotno="93" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">93</div>
                <div data-lotno="94" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">94</div>
                <div data-lotno="95" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">95</div>
                <div data-lotno="96" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">96</div>
                <div data-lotno="97" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">97</div>
                <div data-lotno="98" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">98</div>
                <div data-lotno="99" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">99</div>
                <div data-lotno="100" data-memsts="Apartment3" data-memlot="None" class="grid-itemB3">100</div>
                            </div>
            </div>
            <div class="A3sideA tooltip" id="A3sideA" data-tooltip="Front"><br></tb>Side A</div>
           <div class="A3sideB tooltip" id="A3sideB" class="tooltip" data-tooltip="Back"><br></tb>Side B</div>
           <button id="A3closePopup" class="A3close-button">&times;</button>
        </div>
             <div class="A2" id="A2"><h3 style="color: #e9f9ef;">Apartment 2</h3><br><h5 style="color:#e9f9ef;">Select Side</h5>
                <div class="sideAa2" id="sideAa2"><h3 style="color: white;">Apartment 2 Side A</h3><br>
                
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
               
                      <button id="AA2closePopup" class="AA2closebutton">&times;</button>
                      <div class="SAa2GridA2" id="SAa2GridA2">
                        <div data-lotno="1" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">1</div>
            <div data-lotno="2" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">2</div>
            <div data-lotno="3" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">3</div>
            <div data-lotno="4" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">4</div>
            <div data-lotno="5" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">5</div>
            <div data-lotno="6" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">6</div>
            <div data-lotno="7" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">7</div>
            <div data-lotno="8" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">8</div>
            <div data-lotno="9" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">9</div>
            <div data-lotno="10" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">10</div>
            
            <div data-lotno="11" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">11</div>
            <div data-lotno="12" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">12</div>
            <div data-lotno="13" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">13</div>
            <div data-lotno="14" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">14</div>
            <div data-lotno="15" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">15</div>
            <div data-lotno="16" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">16</div>
            <div data-lotno="17" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">17</div>
            <div data-lotno="18" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">18</div>
            <div data-lotno="19" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">19</div>
            <div data-lotno="20" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">20</div>
            
            <div data-lotno="21" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">21</div>
            <div data-lotno="22" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">22</div>
            <div data-lotno="23" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">23</div>
            <div data-lotno="24" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">24</div>
            <div data-lotno="25" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">25</div>
            <div data-lotno="26" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">26</div>
            <div data-lotno="27" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">27</div>
            <div data-lotno="28" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">28</div>
            <div data-lotno="29" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">29</div>
            <div data-lotno="30" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">30</div>
            
            <div data-lotno="31" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">31</div>
            <div data-lotno="32" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">32</div>
            <div data-lotno="33" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">33</div>
            <div data-lotno="34" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">34</div>
            <div data-lotno="35" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">35</div>
            <div data-lotno="36" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">36</div>
            <div data-lotno="37" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">37</div>
            <div data-lotno="38" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">38</div>
            <div data-lotno="39" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">39</div>
            <div data-lotno="40" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">40</div>
            
            <div data-lotno="41" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">41</div>
            <div data-lotno="42" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">42</div>
            <div data-lotno="43" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">43</div>
            <div data-lotno="44" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">44</div>
            <div data-lotno="45" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">45</div>
            <div data-lotno="46" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">46</div>
            <div data-lotno="47" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">47</div>
            <div data-lotno="48" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">48</div>
            <div data-lotno="49" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">49</div>
            <div data-lotno="50" data-memsts="Apartment2" data-memlot="None" class="grid-itemA2">50</div>
            
                        
                        </div>
            </div>
            <div class="sideBa2" id="sideBa2"><h3 style="color: white;">Apartment 2 Side B</h3><br>
                <button id="BA2closePopup" class="BA2closebutton">&times;</button>
                
                <div class="A1lgndsSA" id="legendBox">
                    <div class="legends">Legend</div>
                    <div class="legendList">
                    <div class="legendU Available"></div>
                    <span>Available slots</span>
                    </div>
                <div class="legendList">
                  <div class="legendU Unavailable"></div>
                  <span>Owned slots</span>
                </div>
              </div>

              <div class="SBa2Grid" id="SBa2Grid">
                <div data-lotno="51" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">51</div>
    <div data-lotno="52" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">52</div>
    <div data-lotno="53" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">53</div>
    <div data-lotno="54" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">54</div>
    <div data-lotno="55" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">55</div>
    <div data-lotno="56" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">56</div>
    <div data-lotno="57" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">57</div>
    <div data-lotno="58" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">58</div>
    <div data-lotno="59" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">59</div>
    <div data-lotno="60" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">60</div>
    
    <div data-lotno="61" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">61</div>
    <div data-lotno="62" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">62</div>
    <div data-lotno="63" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">63</div>
    <div data-lotno="64" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">64</div>
    <div data-lotno="65" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">65</div>
    <div data-lotno="66" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">66</div>
    <div data-lotno="67" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">67</div>
    <div data-lotno="68" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">68</div>
    <div data-lotno="69" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">69</div>
    <div data-lotno="70" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">70</div>
    
    <div data-lotno="71" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">71</div>
    <div data-lotno="72" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">72</div>
    <div data-lotno="73" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">73</div>
    <div data-lotno="74" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">74</div>
    <div data-lotno="75" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">75</div>
    <div data-lotno="76" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">76</div>
    <div data-lotno="77" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">77</div>
    <div data-lotno="78" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">78</div>
    <div data-lotno="79" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">79</div>
    <div data-lotno="80" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">80</div>
    
    <div data-lotno="81" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">81</div>
    <div data-lotno="82" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">82</div>
    <div data-lotno="83" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">83</div>
    <div data-lotno="84" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">84</div>
    <div data-lotno="85" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">85</div>
    <div data-lotno="86" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">86</div>
    <div data-lotno="87" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">87</div>
    <div data-lotno="88" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">88</div>
    <div data-lotno="89" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">89</div>
    <div data-lotno="90" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">90</div>
    
    <div data-lotno="91" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">91</div>
    <div data-lotno="92" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">92</div>
    <div data-lotno="93" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">93</div>
    <div data-lotno="94" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">94</div>
    <div data-lotno="95" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">95</div>
    <div data-lotno="96" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">96</div>
    <div data-lotno="97" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">97</div>
    <div data-lotno="98" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">98</div>
    <div data-lotno="99" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">99</div>
    <div data-lotno="100" data-memsts="Apartment2" data-memlot="None" class="grid-itemB2">100</div>
                
                </div>
            </div>
                <div class="A2sideA tooltip" id="A2sideA" data-tooltip="Front"><br></tb>Side A</div>
              <div class="A2sideB tooltip" id="A2sideB" data-tooltip="Back"><br></tb>Side B</div>
              <button id="A2closePopup" class="A2close-button">&times;</button>
           </div>     
          <div class="A1" id="A1"><h3 style="color: #e9f9ef;">Apartment 1</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
            
            <div class="sideAa1" id="sideAa1"><h3 style="color: white;">Apartment 1 Side A</h3><br>

            <button id="AA1closePopup" class="AA1closebutton">&times;</button>
            
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
              
            
          <div class="SAa1GridA" id="SAa1GridA">
    <div data-lotno="1" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">1</div>
    <div data-lotno="2" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">2</div>
    <div data-lotno="3" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">3</div>
    <div data-lotno="4" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">4</div>
    <div data-lotno="5" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">5</div>
    <div data-lotno="6" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">6</div>
    <div data-lotno="7" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">7</div>
    <div data-lotno="8" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">8</div>
    <div data-lotno="9" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">9</div>
    <div data-lotno="10" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">10</div>
    
    <div data-lotno="11" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">11</div>
    <div data-lotno="12" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">12</div>
    <div data-lotno="13" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">13</div>
    <div data-lotno="14" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">14</div>
    <div data-lotno="15" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">15</div>
    <div data-lotno="16" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">16</div>
    <div data-lotno="17" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">17</div>
    <div data-lotno="18" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">18</div>
    <div data-lotno="19" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">19</div>
    <div data-lotno="20" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">20</div>
    
    <div data-lotno="21" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">21</div>
    <div data-lotno="22" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">22</div>
    <div data-lotno="23" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">23</div>
    <div data-lotno="24" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">24</div>
    <div data-lotno="25" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">25</div>
    <div data-lotno="26" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">26</div>
    <div data-lotno="27" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">27</div>
    <div data-lotno="28" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">28</div>
    <div data-lotno="29" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">29</div>
    <div data-lotno="30" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">30</div>
    
    <div data-lotno="31" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">31</div>
    <div data-lotno="32" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">32</div>
    <div data-lotno="33" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">33</div>
    <div data-lotno="34" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">34</div>
    <div data-lotno="35" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">35</div>
    <div data-lotno="36" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">36</div>
    <div data-lotno="37" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">37</div>
    <div data-lotno="38" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">38</div>
    <div data-lotno="39" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">39</div>
    <div data-lotno="40" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">40</div>
    
    <div data-lotno="41" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">41</div>
    <div data-lotno="42" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">42</div>
    <div data-lotno="43" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">43</div>
    <div data-lotno="44" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">44</div>
    <div data-lotno="45" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">45</div>
    <div data-lotno="46" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">46</div>
    <div data-lotno="47" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">47</div>
    <div data-lotno="48" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">48</div>
    <div data-lotno="49" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">49</div>
    <div data-lotno="50" data-memsts="Apartment1" data-memlot="None" class="grid-itemA">50</div>
            </div>
        </div>
        <div class="item-popup" id="itemPopup">
            <button class="close-popup" id="closePopup">&times;</button>
            <div class="popup-content" id="popupContent"></div>
        </div>
        

        <div class="sideBa1" id="sideBa1"><h3 style="color: white;"> Apartment 1 Side B</h3><br>
            <button id="BA1closePopup" class="BA1closebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>

          <div class="SBa1Grid" id="SBa1Grid">
       
            <div data-lotno="51" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">51</div>
            <div data-lotno="52" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">52</div>
            <div data-lotno="53" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">53</div>
            <div data-lotno="54" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">54</div>
            <div data-lotno="55" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">55</div>
            <div data-lotno="56" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">56</div>
            <div data-lotno="57" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">57</div>
            <div data-lotno="58" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">58</div>
            <div data-lotno="59" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">59</div>
            <div data-lotno="60" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">60</div>
            
            <div data-lotno="61" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">61</div>
            <div data-lotno="62" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">62</div>
            <div data-lotno="63" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">63</div>
            <div data-lotno="64" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">64</div>
            <div data-lotno="65" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">65</div>
            <div data-lotno="66" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">66</div>
            <div data-lotno="67" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">67</div>
            <div data-lotno="68" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">68</div>
            <div data-lotno="69" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">69</div>
            <div data-lotno="70" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">70</div>
            
            <div data-lotno="71" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">71</div>
            <div data-lotno="72" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">72</div>
            <div data-lotno="73" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">73</div>
            <div data-lotno="74" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">74</div>
            <div data-lotno="75" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">75</div>
            <div data-lotno="76" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">76</div>
            <div data-lotno="77" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">77</div>
            <div data-lotno="78" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">78</div>
            <div data-lotno="79" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">79</div>
            <div data-lotno="80" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">80</div>
            
            <div data-lotno="81" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">81</div>
            <div data-lotno="82" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">82</div>
            <div data-lotno="83" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">83</div>
            <div data-lotno="84" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">84</div>
            <div data-lotno="85" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">85</div>
            <div data-lotno="86" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">86</div>
            <div data-lotno="87" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">87</div>
            <div data-lotno="88" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">88</div>
            <div data-lotno="89" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">89</div>
            <div data-lotno="90" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">90</div>
            
            <div data-lotno="91" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">91</div>
            <div data-lotno="92" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">92</div>
            <div data-lotno="93" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">93</div>
            <div data-lotno="94" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">94</div>
            <div data-lotno="95" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">95</div>
            <div data-lotno="96" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">96</div>
            <div data-lotno="97" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">97</div>
            <div data-lotno="98" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">98</div>
            <div data-lotno="99" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">99</div>
            <div data-lotno="100" data-memsts="Apartment1" data-memlot="None" class="grid-itemB">100</div>
                    </div>
        </div>
            <div class="A1sideA tooltip" id="A1sideA" data-tooltip="Front"><br></tb>Side A</div>
           <div class="A1sideB tooltip" id="A1sideB" data-tooltip="Back"><br></tb>Side B</div>
           <button id="A1closePopup" class="A1close-button">&times;</button>
           
        </div>
          <div class="C2" id="C2"><h3 style="color: #e9f9ef;">Columbarium 2</h3><br><h5 style="color: #e9f9ef;">Select Floor</h5>
            
        
            <div class="C21stflr" id="C21stflr"><br></tb>1st Floor </div> 

            
                <div class="C21st" id="C21st"><h3 style="color: #e9f9ef;">Columbarium 2 (1st floor)</h3><br><h5 style="color: #e9f9ef;">Select Block</h5> 
                    <div class="C21stflrSA" id="C21stflrSA"><br></tb>Block 1</div>
                    <div class="C21stflrSB" id="C21stflrSB"><br></tb>Block 2</div>
                    <div class="C21stflrblck3" id="C21stflrblck3"><br></tb>Block 3</div>
                    <div class="C21stflrblck4" id="C21stflrblck4"><br></tb>Block 4</div>
                    <button id="C2closePopup1st" class="C2close-button1st">&times;</button>
                </div>

                <div class="C21stflrS1" id="C21stflrS1"><h3 style="color: #e9f9ef;">Columbarium 2 (1st floor Block 1)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C2S1SA tooltip" id="C2S1SA" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C2S1SB tooltip" id="C2S1SB" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C2S1closePopup" class="C2S1closebutton">&times;</button>
                </div>


                <div class="C21stflrS2" id="C21stflrS2"><h3 style="color: #e9f9ef;">Columbarium 2 (1st floor Block 2)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C2S2SA tooltip" id="C2S2SA" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C2S2SB tooltip" id="C2S2SB" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C2S2closePopup" class="C2S2closebutton">&times;</button>
                </div>
<!--BLK-->

                <div class="C21stflrblk3" id="C21stflrblk3"><h3 style="color: #e9f9ef;">Columbarium 2 (1st floor Block 3)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C2S2blk3A tooltip" id="C2S2blk3A" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C2S2blk3B tooltip" id="C2S2blk3B" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C2S2closePopupblk3" class="C2S2closebuttonblk3">&times;</button>
                </div>
                <div class="C21stflrblk4" id="C21stflrblk4"><h3 style="color: #e9f9ef;">Columbarium 2 (1st floor Block 4)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C2S2blk4A tooltip" id="C2S2blk4A" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C2S2blk4B tooltip" id="C2S2blk4B" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C2S2closePopupblk4" class="C2S2closebuttonblk4">&times;</button>
                </div>

                <div class="C2GRIDS1A" id="C2GRIDS1A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDS1AclosePopup" class="C2GRIDS1Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>

                    <!--columbarium 2 1st floor block 1 side A -->
                    <div class="C2GRIDS1AGrid" id="C2GRIDS1AGrid">
<div data-lotno="1" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">1</div>
<div data-lotno="2" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">2</div>
<div data-lotno="3" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">3</div>
<div data-lotno="4" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">4</div>
<div data-lotno="5" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">5</div>
<div data-lotno="6" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">6</div>
<div data-lotno="7" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">7</div>
<div data-lotno="8" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">8</div>
<div data-lotno="9" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">9</div>
<div data-lotno="10" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">10</div>
<div data-lotno="11" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">11</div>
<div data-lotno="12" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">12</div>
<div data-lotno="13" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">13</div>
<div data-lotno="14" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">14</div>
<div data-lotno="15" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">15</div>
<div data-lotno="16" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">16</div>
<div data-lotno="17" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">17</div>
<div data-lotno="18" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">18</div>
<div data-lotno="19" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">19</div>
<div data-lotno="20" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">20</div>
<div data-lotno="21" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">21</div>
<div data-lotno="22" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">22</div>
<div data-lotno="23" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">23</div>
<div data-lotno="24" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">24</div>
<div data-lotno="25" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">25</div>
<div data-lotno="26" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">26</div>
<div data-lotno="27" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">27</div>
<div data-lotno="28" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">28</div>
<div data-lotno="29" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">29</div>
<div data-lotno="30" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">30</div>
<div data-lotno="31" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">31</div>
<div data-lotno="32" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">32</div>
<div data-lotno="33" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">33</div>
<div data-lotno="34" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">34</div>
<div data-lotno="35" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">35</div>
<div data-lotno="36" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">36</div>
<div data-lotno="37" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">37</div>
<div data-lotno="38" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">38</div>
<div data-lotno="39" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">39</div>
<div data-lotno="40" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1A">40</div>

                    
                    </div>
                </div>
                    

                <div class="C2GRIDS1B" id="C2GRIDS1B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDS1BclosePopup" class="C2GRIDS1Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 1st floor block1 side b -->
                    <div class="C2GRIDS1BGrid" id="C2GRIDS1BGrid">
<div data-lotno="41" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">41</div>
<div data-lotno="42" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">42</div>
<div data-lotno="43" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">43</div>
<div data-lotno="44" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">44</div>
<div data-lotno="45" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">45</div>
<div data-lotno="46" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">46</div>
<div data-lotno="47" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">47</div>
<div data-lotno="48" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">48</div>
<div data-lotno="49" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">49</div>
<div data-lotno="50" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">50</div>
<div data-lotno="51" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">51</div>
<div data-lotno="52" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">52</div>
<div data-lotno="53" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">53</div>
<div data-lotno="54" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">54</div>
<div data-lotno="55" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">55</div>
<div data-lotno="56" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">56</div>
<div data-lotno="57" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">57</div>
<div data-lotno="58" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">58</div>
<div data-lotno="59" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">59</div>
<div data-lotno="60" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">60</div>
<div data-lotno="61" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">61</div>
<div data-lotno="62" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">62</div>
<div data-lotno="63" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">63</div>
<div data-lotno="64" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">64</div>
<div data-lotno="65" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">65</div>
<div data-lotno="66" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">66</div>
<div data-lotno="67" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">67</div>
<div data-lotno="68" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">68</div>
<div data-lotno="69" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">69</div>
<div data-lotno="70" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">70</div>
<div data-lotno="71" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">71</div>
<div data-lotno="72" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">72</div>
<div data-lotno="73" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">73</div>
<div data-lotno="74" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">74</div>
<div data-lotno="75" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">75</div>
<div data-lotno="76" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">76</div>
<div data-lotno="77" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">77</div>
<div data-lotno="78" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">78</div>
<div data-lotno="79" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">79</div>
<div data-lotno="80" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S1B">80</div>

                    </div>
                </div>
                   

                <div class="C2GRIDS2A" id="C2GRIDS2A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDS2AclosePopup" class="C2GRIDS2Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 1st floor block 2 side A -->
                    <div class="C2GRIDS2AGrid" id="C2GRIDS2AGrid">
<div data-lotno="81" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">81</div>
<div data-lotno="82" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">82</div>
<div data-lotno="83" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">83</div>
<div data-lotno="84" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">84</div>
<div data-lotno="85" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">85</div>
<div data-lotno="86" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">86</div>
<div data-lotno="87" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">87</div>
<div data-lotno="88" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">88</div>
<div data-lotno="89" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">89</div>
<div data-lotno="90" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">90</div>
<div data-lotno="91" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">91</div>
<div data-lotno="92" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">92</div>
<div data-lotno="93" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">93</div>
<div data-lotno="94" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">94</div>
<div data-lotno="95" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">95</div>
<div data-lotno="96" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">96</div>
<div data-lotno="97" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">97</div>
<div data-lotno="98" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">98</div>
<div data-lotno="99" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">99</div>
<div data-lotno="100" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">100</div>
<div data-lotno="101" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">101</div>
<div data-lotno="102" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">102</div>
<div data-lotno="103" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">103</div>
<div data-lotno="104" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">104</div>
<div data-lotno="105" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">105</div>
<div data-lotno="106" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">106</div>
<div data-lotno="107" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">107</div>
<div data-lotno="108" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">108</div>
<div data-lotno="109" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">109</div>
<div data-lotno="110" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">110</div>
<div data-lotno="111" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">111</div>
<div data-lotno="112" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">112</div>
<div data-lotno="113" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">113</div>
<div data-lotno="114" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">114</div>
<div data-lotno="115" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">115</div>
<div data-lotno="116" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">116</div>
<div data-lotno="117" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">117</div>
<div data-lotno="118" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">118</div>
<div data-lotno="119" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">119</div>
<div data-lotno="120" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2A">120</div>

                    </div>
                </div>
                   

                <div class="C2GRIDS2B" id="C2GRIDS2B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDS2BclosePopup" class="C2GRIDS2Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
         <!--columbarium 2 1st floor block 2 side b -->
                    <div class="C2GRIDS2BGrid" id="C2GRIDS2BGrid">
<div data-lotno="121" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">121</div>
<div data-lotno="122" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">122</div>
<div data-lotno="123" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">123</div>
<div data-lotno="124" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">124</div>
<div data-lotno="125" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">125</div>
<div data-lotno="126" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">126</div>
<div data-lotno="127" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">127</div>
<div data-lotno="128" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">128</div>
<div data-lotno="129" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">129</div>
<div data-lotno="130" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">130</div>
<div data-lotno="131" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">131</div>
<div data-lotno="132" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">132</div>
<div data-lotno="133" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">133</div>
<div data-lotno="134" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">134</div>
<div data-lotno="135" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">135</div>
<div data-lotno="136" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">136</div>
<div data-lotno="137" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">137</div>
<div data-lotno="138" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">138</div>
<div data-lotno="139" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">139</div>
<div data-lotno="140" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">140</div>
<div data-lotno="141" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">141</div>
<div data-lotno="142" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">142</div>
<div data-lotno="143" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">143</div>
<div data-lotno="144" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">144</div>
<div data-lotno="145" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">145</div>
<div data-lotno="146" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">146</div>
<div data-lotno="147" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">147</div>
<div data-lotno="148" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">148</div>
<div data-lotno="149" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">149</div>
<div data-lotno="150" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">150</div>
<div data-lotno="151" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">151</div>
<div data-lotno="152" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">152</div>
<div data-lotno="153" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">153</div>
<div data-lotno="154" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">154</div>
<div data-lotno="155" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">155</div>
<div data-lotno="156" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">156</div>
<div data-lotno="157" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">157</div>
<div data-lotno="158" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">158</div>
<div data-lotno="159" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">159</div>
<div data-lotno="160" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S2B">160</div>

                    
                    </div>
                </div>

                <div class="C2GRIDblk3A" id="C2GRIDblk3A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDblk3AclosePopup" class="C2GRIDblk3Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
                    <!--columbarium 2 1st floor block 3 side A -->
<div class="C2GRIDblk3AGrid" id="C2GRIDblk3AGrid">
<div data-lotno="161" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">161</div>
<div data-lotno="162" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">162</div>
<div data-lotno="163" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">163</div>
<div data-lotno="164" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">164</div>
<div data-lotno="165" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">165</div>
<div data-lotno="166" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">166</div>
<div data-lotno="167" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">167</div>
<div data-lotno="168" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">168</div>
<div data-lotno="169" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">169</div>
<div data-lotno="170" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">170</div>
<div data-lotno="171" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">171</div>
<div data-lotno="172" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">172</div>
<div data-lotno="173" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">173</div>
<div data-lotno="174" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">174</div>
<div data-lotno="175" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">175</div>
<div data-lotno="176" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">176</div>
<div data-lotno="177" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">177</div>
<div data-lotno="178" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">178</div>
<div data-lotno="179" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">179</div>
<div data-lotno="180" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">180</div>
<div data-lotno="181" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">181</div>
<div data-lotno="182" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">182</div>
<div data-lotno="183" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">183</div>
<div data-lotno="184" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">184</div>
<div data-lotno="185" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">185</div>
<div data-lotno="186" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">186</div>
<div data-lotno="187" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">187</div>
<div data-lotno="188" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">188</div>
<div data-lotno="189" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">189</div>
<div data-lotno="190" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">190</div>
<div data-lotno="191" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">191</div>
<div data-lotno="192" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">192</div>
<div data-lotno="193" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">193</div>
<div data-lotno="194" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">194</div>
<div data-lotno="195" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">195</div>
<div data-lotno="196" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">196</div>
<div data-lotno="197" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">197</div>
<div data-lotno="198" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">198</div>
<div data-lotno="199" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">199</div>
<div data-lotno="200" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3A">200</div>
                    </div>
                </div>

                <div class="C2GRIDblk3B" id="C2GRIDblk3B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDblk3BclosePopup" class="C2GRIDblk3Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
                    <!--columbarium 2 1st floor block 3 side B -->
                    <div class="C2GRIDblk3BGrid" id="C2GRIDblk3BGrid">
<div data-lotno="201" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">201</div>
<div data-lotno="202" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">202</div>
<div data-lotno="203" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">203</div>
<div data-lotno="204" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">204</div>
<div data-lotno="205" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">205</div>
<div data-lotno="206" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">206</div>
<div data-lotno="207" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">207</div>
<div data-lotno="208" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">208</div>
<div data-lotno="209" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">209</div>
<div data-lotno="210" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">210</div>

<div data-lotno="211" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">211</div>
<div data-lotno="212" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">212</div>
<div data-lotno="213" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">213</div>
<div data-lotno="214" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">214</div>
<div data-lotno="215" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">215</div>
<div data-lotno="216" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">216</div>
<div data-lotno="217" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">217</div>
<div data-lotno="218" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">218</div>
<div data-lotno="219" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">219</div>
<div data-lotno="220" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">220</div>

<div data-lotno="221" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">221</div>
<div data-lotno="222" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">222</div>
<div data-lotno="223" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">223</div>
<div data-lotno="224" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">224</div>
<div data-lotno="225" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">225</div>
<div data-lotno="226" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">226</div>
<div data-lotno="227" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">227</div>
<div data-lotno="228" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">228</div>
<div data-lotno="229" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">229</div>
<div data-lotno="230" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">230</div>

<div data-lotno="231" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">231</div>
<div data-lotno="232" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">232</div>
<div data-lotno="233" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">233</div>
<div data-lotno="234" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">234</div>
<div data-lotno="235" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">235</div>
<div data-lotno="236" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">236</div>
<div data-lotno="237" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">237</div>
<div data-lotno="238" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">238</div>
<div data-lotno="239" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">239</div>
<div data-lotno="240" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk3B">240</div>

                    </div>
                </div>


                <div class="C2GRIDblk4A" id="C2GRIDblk4A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDblk4AclosePopup" class="C2GRIDblk4Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
                    <!--columbarium 2 1st floor block 4 side A -->
                    <div class="C2GRIDblk4AGrid" id="C2GRIDblk4AGrid">
<div data-lotno="241" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">241</div>
<div data-lotno="242" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">242</div>
<div data-lotno="243" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">243</div>
<div data-lotno="244" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">244</div>
<div data-lotno="245" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">245</div>
<div data-lotno="246" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">246</div>
<div data-lotno="247" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">247</div>
<div data-lotno="248" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">248</div>
<div data-lotno="249" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">249</div>
<div data-lotno="250" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">250</div>

<div data-lotno="251" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">251</div>
<div data-lotno="252" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">252</div>
<div data-lotno="253" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">253</div>
<div data-lotno="254" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">254</div>
<div data-lotno="255" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">255</div>
<div data-lotno="256" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">256</div>
<div data-lotno="257" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">257</div>
<div data-lotno="258" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">258</div>
<div data-lotno="259" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">259</div>
<div data-lotno="260" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">260</div>

<div data-lotno="261" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">261</div>
<div data-lotno="262" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">262</div>
<div data-lotno="263" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">263</div>
<div data-lotno="264" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">264</div>
<div data-lotno="265" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">265</div>
<div data-lotno="266" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">266</div>
<div data-lotno="267" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">267</div>
<div data-lotno="268" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">268</div>
<div data-lotno="269" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">269</div>
<div data-lotno="270" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">270</div>

<div data-lotno="271" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">271</div>
<div data-lotno="272" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">272</div>
<div data-lotno="273" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">273</div>
<div data-lotno="274" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">274</div>
<div data-lotno="275" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">275</div>
<div data-lotno="276" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">276</div>
<div data-lotno="277" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">277</div>
<div data-lotno="278" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">278</div>
<div data-lotno="279" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">279</div>
<div data-lotno="280" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4A">280</div>

                    </div>
                </div>


                <div class="C2GRIDblk4B" id="C2GRIDblk4B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDblk4BclosePopup" class="C2GRIDblk4Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
                    <!--columbarium 2 1st floor block 4 side B -->
                    <div class="C2GRIDblk4BGrid" id="C2GRIDblk4BGrid">
<div data-lotno="281" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">281</div>
<div data-lotno="282" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">282</div>
<div data-lotno="283" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">283</div>
<div data-lotno="284" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">284</div>
<div data-lotno="285" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">285</div>
<div data-lotno="286" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">286</div>
<div data-lotno="287" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">287</div>
<div data-lotno="288" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">288</div>
<div data-lotno="289" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">289</div>
<div data-lotno="290" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">290</div>

<div data-lotno="291" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">291</div>
<div data-lotno="292" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">292</div>
<div data-lotno="293" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">293</div>
<div data-lotno="294" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">294</div>
<div data-lotno="295" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">295</div>
<div data-lotno="296" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">296</div>
<div data-lotno="297" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">297</div>
<div data-lotno="298" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">298</div>
<div data-lotno="299" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">299</div>
<div data-lotno="300" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">300</div>

<div data-lotno="301" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">301</div>
<div data-lotno="302" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">302</div>
<div data-lotno="303" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">303</div>
<div data-lotno="304" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">304</div>
<div data-lotno="305" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">305</div>
<div data-lotno="306" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">306</div>
<div data-lotno="307" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">307</div>
<div data-lotno="308" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">308</div>
<div data-lotno="309" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">309</div>
<div data-lotno="310" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">310</div>

<div data-lotno="311" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">311</div>
<div data-lotno="312" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">312</div>
<div data-lotno="313" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">313</div>
<div data-lotno="314" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">314</div>
<div data-lotno="315" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">315</div>
<div data-lotno="316" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">316</div>
<div data-lotno="317" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">317</div>
<div data-lotno="318" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">318</div>
<div data-lotno="319" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">319</div>
<div data-lotno="320" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2blk4B">320</div>

                    </div>
                </div>
               

                                
                <div class="C22ndflr" id="C22ndflr"><br></tb>2nd Floor</div>
                
                <div class="C22nd" id="C22nd"><h3 style="color: #e9f9ef;">Columbarium 2 (2nd floor)</h3><br><h5 style="color: #e9f9ef;">Select Block</h5> 
                    
                    <div class="C22ndflrSA" id="C22ndflrSA"><br></tb>Block 1</div>
                    <div class="C22ndflrSB" id="C22ndflrSB"><br></tb>Block 2</div>
                    <div class="C22ndflrblck3" id="C22ndflrblck3"><br></tb>Block 3</div>
                    <div class="C22ndflrblck4" id="C22ndflrblck4"><br></tb>Block 4</div>
                    <button id="C2closePopup2nd" class="C2close-button2nd">&times;</button>
                </div>  
             
                <div class="C22ndflrS1" id="C22ndflrS1"><h3 style="color: #e9f9ef;">Columbarium 2 (2nd floor Block 1)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C22SA tooltip" id="C22SA" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C22SB tooltip" id="C22SB" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C22S1closePopup" class="C22S1closebutton">&times;</button>
                </div>

                <div class="C22ndflrS2" id="C22ndflrS2"><h3 style="color: #e9f9ef;">Columbarium 2 (2nd floor Block 2)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C22SA2 tooltip" id="C22SA2" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C22SB2 tooltip" id="C22SB2" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C22S2closePopup" class="C22S2closebutton">&times;</button>
                </div>
                <!--2ndflr blck -->
                <div class="C22ndflrblk3" id="C22ndflrblk3"><h3 style="color: #e9f9ef;">Columbarium 2 (2nd floor Block 3)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C22blk3A tooltip" id="C22blk3A" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C22blk3B tooltip" id="C22blk3B" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C22blk3closePopup" class="C22blk3closebutton">&times;</button>
                </div>

                <div class="C22ndflrblk4" id="C22ndflrblk4"><h3 style="color: #e9f9ef;">Columbarium 2 (2nd floor Block 4)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
                    <div class="C22blk4A tooltip" id="C22blk4A" data-tooltip="Front"><br></tb>Side A</div>
                    <div class="C22blk4B tooltip" id="C22blk4B" data-tooltip="Back"><br></tb>Side B</div>
                   <button id="C22blk4closePopup" class="C22blk4closebutton">&times;</button>
                </div>



                <div class="C2GRIDS12A" id="C2GRIDS12A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDS12AclosePopup" class="C2GRIDS12Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 1 Side A-->
                    <div class="C2GRIDS12AGrid" id="C2GRIDS12AGrid">
<div data-lotno="321" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">321</div>
<div data-lotno="322" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">322</div>
<div data-lotno="323" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">323</div>
<div data-lotno="324" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">324</div>
<div data-lotno="325" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">325</div>
<div data-lotno="326" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">326</div>
<div data-lotno="327" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">327</div>
<div data-lotno="328" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">328</div>
<div data-lotno="329" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">329</div>
<div data-lotno="330" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">330</div>

<div data-lotno="331" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">331</div>
<div data-lotno="332" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">332</div>
<div data-lotno="333" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">333</div>
<div data-lotno="334" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">334</div>
<div data-lotno="335" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">335</div>
<div data-lotno="336" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">336</div>
<div data-lotno="337" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">337</div>
<div data-lotno="338" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">338</div>
<div data-lotno="339" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">339</div>
<div data-lotno="340" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">340</div>

<div data-lotno="341" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">341</div>
<div data-lotno="342" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">342</div>
<div data-lotno="343" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">343</div>
<div data-lotno="344" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">344</div>
<div data-lotno="345" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">345</div>
<div data-lotno="346" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">346</div>
<div data-lotno="347" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">347</div>
<div data-lotno="348" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">348</div>
<div data-lotno="349" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">349</div>
<div data-lotno="350" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">350</div>

<div data-lotno="351" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">351</div>
<div data-lotno="352" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">352</div>
<div data-lotno="353" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">353</div>
<div data-lotno="354" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">354</div>
<div data-lotno="355" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">355</div>
<div data-lotno="356" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">356</div>
<div data-lotno="357" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">357</div>
<div data-lotno="358" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">358</div>
<div data-lotno="359" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">359</div>
<div data-lotno="360" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12A">360</div>

                    
                    </div>
                </div>

                <div class="C2GRIDS12B" id="C2GRIDS12B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDS12BclosePopup" class="C2GRIDS12Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 1 Side B-->
                    <div class="C2GRIDS12BGrid" id="C2GRIDS12BGrid">
<div data-lotno="361" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">361</div>
<div data-lotno="362" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">362</div>
<div data-lotno="363" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">363</div>
<div data-lotno="364" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">364</div>
<div data-lotno="365" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">365</div>
<div data-lotno="366" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">366</div>
<div data-lotno="367" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">367</div>
<div data-lotno="368" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">368</div>
<div data-lotno="369" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">369</div>
<div data-lotno="370" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">370</div>

<div data-lotno="371" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">371</div>
<div data-lotno="372" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">372</div>
<div data-lotno="373" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">373</div>
<div data-lotno="374" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">374</div>
<div data-lotno="375" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">375</div>
<div data-lotno="376" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">376</div>
<div data-lotno="377" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">377</div>
<div data-lotno="378" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">378</div>
<div data-lotno="379" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">379</div>
<div data-lotno="380" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">380</div>

<div data-lotno="381" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">381</div>
<div data-lotno="382" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">382</div>
<div data-lotno="383" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">383</div>
<div data-lotno="384" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">384</div>
<div data-lotno="385" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">385</div>
<div data-lotno="386" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">386</div>
<div data-lotno="387" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">387</div>
<div data-lotno="388" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">388</div>
<div data-lotno="389" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">389</div>
<div data-lotno="390" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">390</div>

<div data-lotno="391" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">391</div>
<div data-lotno="392" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">392</div>
<div data-lotno="393" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">393</div>
<div data-lotno="394" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">394</div>
<div data-lotno="395" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">395</div>
<div data-lotno="396" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">396</div>
<div data-lotno="397" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">397</div>
<div data-lotno="398" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">398</div>
<div data-lotno="399" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">399</div>
<div data-lotno="400" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S12B">400</div>

                    </div>
                </div>

                <div class="C2GRIDS22A" id="C2GRIDS22A"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2GRIDS22AclosePopup" class="C2GRIDS22Aclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 2 Side A-->
                    <div class="C2GRIDS22AGrid" id="C2GRIDS22AGrid">
<div data-lotno="401" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">401</div>
<div data-lotno="402" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">402</div>
<div data-lotno="403" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">403</div>
<div data-lotno="404" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">404</div>
<div data-lotno="405" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">405</div>
<div data-lotno="406" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">406</div>
<div data-lotno="407" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">407</div>
<div data-lotno="408" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">408</div>
<div data-lotno="409" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">409</div>
<div data-lotno="410" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">410</div>

<div data-lotno="411" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">411</div>
<div data-lotno="412" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">412</div>
<div data-lotno="413" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">413</div>
<div data-lotno="414" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">414</div>
<div data-lotno="415" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">415</div>
<div data-lotno="416" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">416</div>
<div data-lotno="417" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">417</div>
<div data-lotno="418" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">418</div>
<div data-lotno="419" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">419</div>
<div data-lotno="420" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">420</div>

<div data-lotno="421" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">421</div>
<div data-lotno="422" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">422</div>
<div data-lotno="423" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">423</div>
<div data-lotno="424" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">424</div>
<div data-lotno="425" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">425</div>
<div data-lotno="426" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">426</div>
<div data-lotno="427" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">427</div>
<div data-lotno="428" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">428</div>
<div data-lotno="429" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">429</div>
<div data-lotno="430" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">430</div>

<div data-lotno="431" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">431</div>
<div data-lotno="432" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">432</div>
<div data-lotno="433" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">433</div>
<div data-lotno="434" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">434</div>
<div data-lotno="435" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">435</div>
<div data-lotno="436" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">436</div>
<div data-lotno="437" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">437</div>
<div data-lotno="438" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">438</div>
<div data-lotno="439" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">439</div>
<div data-lotno="440" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22A">440</div>

                    </div>
                </div>

                <div class="C2GRIDS22B" id="C2GRIDS22B"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2GRIDS22BclosePopup" class="C2GRIDS22Bclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 2 Side B-->
                    <div class="C2GRIDS22BGrid" id="C2GRIDS22BGrid">
<div data-lotno="441" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">441</div>
<div data-lotno="442" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">442</div>
<div data-lotno="443" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">443</div>
<div data-lotno="444" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">444</div>
<div data-lotno="445" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">445</div>
<div data-lotno="446" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">446</div>
<div data-lotno="447" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">447</div>
<div data-lotno="448" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">448</div>
<div data-lotno="449" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">449</div>
<div data-lotno="450" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">450</div>

<div data-lotno="451" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">451</div>
<div data-lotno="452" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">452</div>
<div data-lotno="453" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">453</div>
<div data-lotno="454" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">454</div>
<div data-lotno="455" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">455</div>
<div data-lotno="456" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">456</div>
<div data-lotno="457" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">457</div>
<div data-lotno="458" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">458</div>
<div data-lotno="459" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">459</div>
<div data-lotno="460" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">460</div>

<div data-lotno="461" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">461</div>
<div data-lotno="462" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">462</div>
<div data-lotno="463" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">463</div>
<div data-lotno="464" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">464</div>
<div data-lotno="465" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">465</div>
<div data-lotno="466" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">466</div>
<div data-lotno="467" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">467</div>
<div data-lotno="468" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">468</div>
<div data-lotno="469" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">469</div>
<div data-lotno="470" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">470</div>

<div data-lotno="471" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">471</div>
<div data-lotno="472" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">472</div>
<div data-lotno="473" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">473</div>
<div data-lotno="474" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">474</div>
<div data-lotno="475" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">475</div>
<div data-lotno="476" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">476</div>
<div data-lotno="477" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">477</div>
<div data-lotno="478" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">478</div>
<div data-lotno="479" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">479</div>
<div data-lotno="480" data-memsts="Columbarium2" data-memlot="None" class="grid-itemC2S22B">480</div>

                    
                    </div>
                </div>


                <div class="C2blk3GRID" id="C2blk3GRID"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2blk3GRIDclosePopup" class="C2blk3GRIDclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 3 Side A-->
                    <div class="C2blk3GRIDGrid" id="C2blk3GRIDGrid">
<div data-lotno="481" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">481</div>
<div data-lotno="482" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">482</div>
<div data-lotno="483" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">483</div>
<div data-lotno="484" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">484</div>
<div data-lotno="485" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">485</div>
<div data-lotno="486" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">486</div>
<div data-lotno="487" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">487</div>
<div data-lotno="488" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">488</div>
<div data-lotno="489" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">489</div>
<div data-lotno="490" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">490</div>

<div data-lotno="491" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">491</div>
<div data-lotno="492" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">492</div>
<div data-lotno="493" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">493</div>
<div data-lotno="494" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">494</div>
<div data-lotno="495" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">495</div>
<div data-lotno="496" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">496</div>
<div data-lotno="497" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">497</div>
<div data-lotno="498" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">498</div>
<div data-lotno="499" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">499</div>
<div data-lotno="500" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">500</div>

<div data-lotno="501" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">501</div>
<div data-lotno="502" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">502</div>
<div data-lotno="503" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">503</div>
<div data-lotno="504" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">504</div>
<div data-lotno="505" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">505</div>
<div data-lotno="506" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">506</div>
<div data-lotno="507" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">507</div>
<div data-lotno="508" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">508</div>
<div data-lotno="509" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">509</div>
<div data-lotno="510" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">510</div>

<div data-lotno="511" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">511</div>
<div data-lotno="512" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">512</div>
<div data-lotno="513" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">513</div>
<div data-lotno="514" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">514</div>
<div data-lotno="515" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">515</div>
<div data-lotno="516" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">516</div>
<div data-lotno="517" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">517</div>
<div data-lotno="518" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">518</div>
<div data-lotno="519" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">519</div>
<div data-lotno="520" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3AC2">520</div>

                    
                    </div>
                </div>

                
                <div class="C2blk3BGRID" id="C2blk3BGRID"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2blk3BGRIDclosePopup" class="C2blk3BGRIDclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 3 Side B-->
                    <div class="C2blk3BGRIDGrid" id="C2blk3BGRIDGrid">
<div data-lotno="521" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">521</div>
<div data-lotno="522" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">522</div>
<div data-lotno="523" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">523</div>
<div data-lotno="524" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">524</div>
<div data-lotno="525" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">525</div>
<div data-lotno="526" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">526</div>
<div data-lotno="527" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">527</div>
<div data-lotno="528" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">528</div>
<div data-lotno="529" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">529</div>
<div data-lotno="530" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">530</div>

<div data-lotno="531" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">531</div>
<div data-lotno="532" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">532</div>
<div data-lotno="533" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">533</div>
<div data-lotno="534" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">534</div>
<div data-lotno="535" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">535</div>
<div data-lotno="536" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">536</div>
<div data-lotno="537" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">537</div>
<div data-lotno="538" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">538</div>
<div data-lotno="539" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">539</div>
<div data-lotno="540" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">540</div>

<div data-lotno="541" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">541</div>
<div data-lotno="542" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">542</div>
<div data-lotno="543" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">543</div>
<div data-lotno="544" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">544</div>
<div data-lotno="545" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">545</div>
<div data-lotno="546" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">546</div>
<div data-lotno="547" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">547</div>
<div data-lotno="548" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">548</div>
<div data-lotno="549" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">549</div>
<div data-lotno="550" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">550</div>

<div data-lotno="551" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">551</div>
<div data-lotno="552" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">552</div>
<div data-lotno="553" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">553</div>
<div data-lotno="554" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">554</div>
<div data-lotno="555" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">555</div>
<div data-lotno="556" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">556</div>
<div data-lotno="557" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">557</div>
<div data-lotno="558" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">558</div>
<div data-lotno="559" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">559</div>
<div data-lotno="560" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk3BC2">560</div>

                    </div>
                </div>


                <div class="C2blk4AGRID" id="C2blk4AGRID"><h3 style="color: white;">Side A</h3><br>
                    <button id="C2blk4AGRIDclosePopup" class="C2blk4AGRIDclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 4 Side A-->
                    <div class="C2blk4AGRIDGrid" id="C2blk4AGRIDGrid">
<div data-lotno="561" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">561</div>
<div data-lotno="562" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">562</div>
<div data-lotno="563" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">563</div>
<div data-lotno="564" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">564</div>
<div data-lotno="565" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">565</div>
<div data-lotno="566" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">566</div>
<div data-lotno="567" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">567</div>
<div data-lotno="568" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">568</div>
<div data-lotno="569" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">569</div>
<div data-lotno="570" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">570</div>

<div data-lotno="571" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">571</div>
<div data-lotno="572" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">572</div>
<div data-lotno="573" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">573</div>
<div data-lotno="574" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">574</div>
<div data-lotno="575" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">575</div>
<div data-lotno="576" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">576</div>
<div data-lotno="577" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">577</div>
<div data-lotno="578" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">578</div>
<div data-lotno="579" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">579</div>
<div data-lotno="580" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">580</div>

<div data-lotno="581" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">581</div>
<div data-lotno="582" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">582</div>
<div data-lotno="583" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">583</div>
<div data-lotno="584" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">584</div>
<div data-lotno="585" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">585</div>
<div data-lotno="586" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">586</div>
<div data-lotno="587" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">587</div>
<div data-lotno="588" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">588</div>
<div data-lotno="589" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">589</div>
<div data-lotno="590" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">590</div>

<div data-lotno="591" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">591</div>
<div data-lotno="592" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">592</div>
<div data-lotno="593" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">593</div>
<div data-lotno="594" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">594</div>
<div data-lotno="595" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">595</div>
<div data-lotno="596" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">596</div>
<div data-lotno="597" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">597</div>
<div data-lotno="598" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">598</div>
<div data-lotno="599" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">599</div>
<div data-lotno="600" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4AC2">600</div>

                    </div>
                </div>

                <div class="C2blk4BGRID" id="C2blk4BGRID"><h3 style="color: white;">Side B</h3><br>
                    <button id="C2blk4BGRIDclosePopup" class="C2blk4BGRIDclosebutton">&times;</button>
                   
                    <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--columbarium 2 2nd floor block 4 Side B-->
                    <div class="C2blk4BGRIDGrid" id="C2blk4BGRIDGrid">
<div data-lotno="601" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">601</div>
<div data-lotno="602" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">602</div>
<div data-lotno="603" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">603</div>
<div data-lotno="604" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">604</div>
<div data-lotno="605" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">605</div>
<div data-lotno="606" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">606</div>
<div data-lotno="607" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">607</div>
<div data-lotno="608" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">608</div>
<div data-lotno="609" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">609</div>
<div data-lotno="610" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">610</div>

<div data-lotno="611" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">611</div>
<div data-lotno="612" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">612</div>
<div data-lotno="613" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">613</div>
<div data-lotno="614" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">614</div>
<div data-lotno="615" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">615</div>
<div data-lotno="616" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">616</div>
<div data-lotno="617" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">617</div>
<div data-lotno="618" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">618</div>
<div data-lotno="619" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">619</div>
<div data-lotno="620" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">620</div>

<div data-lotno="621" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">621</div>
<div data-lotno="622" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">622</div>
<div data-lotno="623" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">623</div>
<div data-lotno="624" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">624</div>
<div data-lotno="625" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">625</div>
<div data-lotno="626" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">626</div>
<div data-lotno="627" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">627</div>
<div data-lotno="628" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">628</div>
<div data-lotno="629" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">629</div>
<div data-lotno="630" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">630</div>

<div data-lotno="631" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">631</div>
<div data-lotno="632" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">632</div>
<div data-lotno="633" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">633</div>
<div data-lotno="634" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">634</div>
<div data-lotno="635" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">635</div>
<div data-lotno="636" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">636</div>
<div data-lotno="637" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">637</div>
<div data-lotno="638" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">638</div>
<div data-lotno="639" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">639</div>
<div data-lotno="640" data-memsts="Columbarium2" data-memlot="None" class="grid-itemblk4BC2">640</div>

                    
                    </div>
                </div>



                

                <button id="C2closePopup" class="C2close-button">&times;</button>
            </div>

        <div class="C1" id="C1"><h3 style="color: #e9f9ef;">Columbarium 1</h3><br><h5 style="color: #e9f9ef;">Select Floor</h5>
          
            <div class="C11stflr" id="C11stflr"><br></tb>1st Floor </div>
                <div class="C11st" id="C11st"><h3 style="color: #e9f9ef;">Columbarium 1 (1st floor)</h3><br><h5 style="color: #e9f9ef;">Select Block</h5> 
                    <div class="C11stflrSA" id="C11stflrSA"><br></tb>Block 1</div>
                    <div class="C11stflrSB" id="C11stflrSB"><br></tb>Block 2</div>
                    <div class="C11stflrblk3" id="C11stflrblk3"><br></tb>Block 3</div>
                    <div class="C11stflrblk4" id="C11stflrblk4"><br></tb>Block 4</div>
            <button id="C1closePopup1st" class="C1close-button1st">&times;</button>
        </div>
<!--block3 C1 1st  --> <div class="C11stblk3" id="C11stblk3"><h3 style="color: #e9f9ef;">Columbarium 1 (1st floor Block 3)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
            <div class="C11stflrblk3A tooltip" id="C11stflrblk3A" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C11stflrblk3B tooltip" id="C11stflrblk3B" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C11stclosePopupblk3" class="C11stclosebuttonblk3">&times;</button>
        </div>
<!-- blck4-->        

        <div class="C11stblk4" id="C11stblk4"><h3 style="color: #e9f9ef;">Columbarium 1 (1st floor Block 4)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
            <div class="C11stflrblk4A tooltip" id="C11stflrblk4A" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C11stflrblk4B tooltip" id="C11stflrblk4B" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C11stclosePopupblk4" class="C11stclosebuttonblk4">&times;</button>
        </div>
<!-- -->        
        <div class="C11stS1" id="C11stS1"><h3 style="color: #e9f9ef;">Columbarium 1 (1st floor Block 1)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
            <div class="C11stflrSSA tooltip" id="C11stflrSSA" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C11stflrSSB tooltip" id="C11stflrSSB" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C11stclosePopupS" class="C11stclosebuttonS">&times;</button>
        </div>
        <div class="C1GRIDS11A" id="C1GRIDS11A"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDS11AclosePopup" class="C1GRIDS11Aclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            <!--columbarium 1 1st floor block 1 Side A-->
            <div class="C1GRIDS11AGrid" id="C1GRIDS11AGrid">
<div data-lotno="1" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">1</div>
<div data-lotno="2" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">2</div>
<div data-lotno="3" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">3</div>
<div data-lotno="4" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">4</div>
<div data-lotno="5" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">5</div>
<div data-lotno="6" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">6</div>
<div data-lotno="7" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">7</div>
<div data-lotno="8" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">8</div>
<div data-lotno="9" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">9</div>
<div data-lotno="10" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">10</div>

<div data-lotno="11" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">11</div>
<div data-lotno="12" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">12</div>
<div data-lotno="13" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">13</div>
<div data-lotno="14" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">14</div>
<div data-lotno="15" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">15</div>
<div data-lotno="16" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">16</div>
<div data-lotno="17" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">17</div>
<div data-lotno="18" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">18</div>
<div data-lotno="19" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">19</div>
<div data-lotno="20" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">20</div>

<div data-lotno="21" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">21</div>
<div data-lotno="22" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">22</div>
<div data-lotno="23" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">23</div>
<div data-lotno="24" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">24</div>
<div data-lotno="25" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">25</div>
<div data-lotno="26" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">26</div>
<div data-lotno="27" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">27</div>
<div data-lotno="28" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">28</div>
<div data-lotno="29" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">29</div>
<div data-lotno="30" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">30</div>

<div data-lotno="31" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">31</div>
<div data-lotno="32" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">32</div>
<div data-lotno="33" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">33</div>
<div data-lotno="34" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">34</div>
<div data-lotno="35" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">35</div>
<div data-lotno="36" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">36</div>
<div data-lotno="37" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">37</div>
<div data-lotno="38" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">38</div>
<div data-lotno="39" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">39</div>
<div data-lotno="40" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11A">40</div>

            
            </div>
        </div>

        <div class="C1GRIDS11B" id="C1GRIDS11B"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDS11BclosePopup" class="C1GRIDS11Bclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
<!--columbarium 1 1st floor block 1 Side B-->
            <div class="C1GRIDS11BGrid" id="C1GRIDS11BGrid">
<div data-lotno="41" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">41</div>
<div data-lotno="42" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">42</div>
<div data-lotno="43" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">43</div>
<div data-lotno="44" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">44</div>
<div data-lotno="45" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">45</div>
<div data-lotno="46" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">46</div>
<div data-lotno="47" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">47</div>
<div data-lotno="48" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">48</div>
<div data-lotno="49" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">49</div>
<div data-lotno="50" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">50</div>

<div data-lotno="51" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">51</div>
<div data-lotno="52" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">52</div>
<div data-lotno="53" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">53</div>
<div data-lotno="54" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">54</div>
<div data-lotno="55" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">55</div>
<div data-lotno="56" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">56</div>
<div data-lotno="57" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">57</div>
<div data-lotno="58" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">58</div>
<div data-lotno="59" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">59</div>
<div data-lotno="60" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">60</div>

<div data-lotno="61" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">61</div>
<div data-lotno="62" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">62</div>
<div data-lotno="63" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">63</div>
<div data-lotno="64" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">64</div>
<div data-lotno="65" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">65</div>
<div data-lotno="66" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">66</div>
<div data-lotno="67" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">67</div>
<div data-lotno="68" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">68</div>
<div data-lotno="69" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">69</div>
<div data-lotno="70" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">70</div>

<div data-lotno="71" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">71</div>
<div data-lotno="72" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">72</div>
<div data-lotno="73" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">73</div>
<div data-lotno="74" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">74</div>
<div data-lotno="75" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">75</div>
<div data-lotno="76" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">76</div>
<div data-lotno="77" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">77</div>
<div data-lotno="78" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">78</div>
<div data-lotno="79" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">79</div>
<div data-lotno="80" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S11B">80</div>

            </div>
        </div>


        <div class="C11stS2" id="C11stS2"><h3 style="color: #e9f9ef;">Columbarium 1 (1st floor block 2)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
            <div class="C11stflrS2SA tooltip" id="C11stflrS2SA" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C11stflrS2SB tooltip" id="C11stflrS2SB" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C11stclosePopupS2" class="C11stclosebuttonS2">&times;</button>
    
        </div>
        <div class="C1GRIDS22A" id="C1GRIDS22A"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDS22AclosePopup" class="C1GRIDS22Aclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
<!--columbarium 1 1st floor block 2 Side A-->
            <div class="C1GRIDS22AGrid" id="C1GRIDS22AGrid">
<div data-lotno="81" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">81</div>
<div data-lotno="82" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">82</div>
<div data-lotno="83" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">83</div>
<div data-lotno="84" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">84</div>
<div data-lotno="85" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">85</div>
<div data-lotno="86" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">86</div>
<div data-lotno="87" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">87</div>
<div data-lotno="88" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">88</div>
<div data-lotno="89" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">89</div>
<div data-lotno="90" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">90</div>

<div data-lotno="91" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">91</div>
<div data-lotno="92" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">92</div>
<div data-lotno="93" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">93</div>
<div data-lotno="94" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">94</div>
<div data-lotno="95" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">95</div>
<div data-lotno="96" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">96</div>
<div data-lotno="97" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">97</div>
<div data-lotno="98" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">98</div>
<div data-lotno="99" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">99</div>
<div data-lotno="100" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">100</div>

<div data-lotno="101" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">101</div>
<div data-lotno="102" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">102</div>
<div data-lotno="103" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">103</div>
<div data-lotno="104" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">104</div>
<div data-lotno="105" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">105</div>
<div data-lotno="106" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">106</div>
<div data-lotno="107" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">107</div>
<div data-lotno="108" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">108</div>
<div data-lotno="109" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">109</div>
<div data-lotno="110" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">110</div>

<div data-lotno="111" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">111</div>
<div data-lotno="112" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">112</div>
<div data-lotno="113" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">113</div>
<div data-lotno="114" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">114</div>
<div data-lotno="115" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">115</div>
<div data-lotno="116" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">116</div>
<div data-lotno="117" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">117</div>
<div data-lotno="118" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">118</div>
<div data-lotno="119" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">119</div>
<div data-lotno="120" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22A">120</div>

            
            </div>
        </div>

        <div class="C1GRIDS22B" id="C1GRIDS22B"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDS22BclosePopup" class="C1GRIDS22Aclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
<!--columbarium 1 1st floor block 2 Side B-->
            <div class="C1GRIDS22BGrid" id="C1GRIDS22BGrid">
<div data-lotno="121" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">121</div>
<div data-lotno="122" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">122</div>
<div data-lotno="123" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">123</div>
<div data-lotno="124" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">124</div>
<div data-lotno="125" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">125</div>
<div data-lotno="126" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">126</div>
<div data-lotno="127" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">127</div>
<div data-lotno="128" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">128</div>
<div data-lotno="129" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">129</div>
<div data-lotno="130" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">130</div>

<div data-lotno="131" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">131</div>
<div data-lotno="132" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">132</div>
<div data-lotno="133" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">133</div>
<div data-lotno="134" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">134</div>
<div data-lotno="135" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">135</div>
<div data-lotno="136" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">136</div>
<div data-lotno="137" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">137</div>
<div data-lotno="138" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">138</div>
<div data-lotno="139" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">139</div>
<div data-lotno="140" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">140</div>

<div data-lotno="141" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">141</div>
<div data-lotno="142" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">142</div>
<div data-lotno="143" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">143</div>
<div data-lotno="144" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">144</div>
<div data-lotno="145" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">145</div>
<div data-lotno="146" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">146</div>
<div data-lotno="147" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">147</div>
<div data-lotno="148" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">148</div>
<div data-lotno="149" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">149</div>
<div data-lotno="150" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">150</div>

<div data-lotno="151" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">151</div>
<div data-lotno="152" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">152</div>
<div data-lotno="153" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">153</div>
<div data-lotno="154" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">154</div>
<div data-lotno="155" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">155</div>
<div data-lotno="156" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">156</div>
<div data-lotno="157" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">157</div>
<div data-lotno="158" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">158</div>
<div data-lotno="159" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">159</div>
<div data-lotno="160" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1S22B">160</div>

            
            </div>
        </div>
        <div class="C1GRIDBLK3A" id="C1GRIDBLK3A"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDBLK3AclosePopup" class="C1GRIDBLK3Aclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            <!--columbarium 1 1st floor block 3 Side A-->
            <div class="C1GRIDBLK3AGrid" id="C1GRIDBLK3AGrid">
<div data-lotno="161" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">161</div>
<div data-lotno="162" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">162</div>
<div data-lotno="163" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">163</div>
<div data-lotno="164" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">164</div>
<div data-lotno="165" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">165</div>
<div data-lotno="166" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">166</div>
<div data-lotno="167" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">167</div>
<div data-lotno="168" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">168</div>
<div data-lotno="169" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">169</div>
<div data-lotno="170" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">170</div>

<div data-lotno="171" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">171</div>
<div data-lotno="172" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">172</div>
<div data-lotno="173" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">173</div>
<div data-lotno="174" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">174</div>
<div data-lotno="175" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">175</div>
<div data-lotno="176" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">176</div>
<div data-lotno="177" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">177</div>
<div data-lotno="178" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">178</div>
<div data-lotno="179" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">179</div>
<div data-lotno="180" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">180</div>

<div data-lotno="181" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">181</div>
<div data-lotno="182" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">182</div>
<div data-lotno="183" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">183</div>
<div data-lotno="184" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">184</div>
<div data-lotno="185" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">185</div>
<div data-lotno="186" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">186</div>
<div data-lotno="187" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">187</div>
<div data-lotno="188" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">188</div>
<div data-lotno="189" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">189</div>
<div data-lotno="190" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">190</div>

<div data-lotno="191" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">191</div>
<div data-lotno="192" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">192</div>
<div data-lotno="193" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">193</div>
<div data-lotno="194" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">194</div>
<div data-lotno="195" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">195</div>
<div data-lotno="196" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">196</div>
<div data-lotno="197" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">197</div>
<div data-lotno="198" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">198</div>
<div data-lotno="199" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">199</div>
<div data-lotno="200" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3A">200</div>

            </div>
        </div>


        <div class="C1GRIDBLK3B" id="C1GRIDBLK3B"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDBLK3BclosePopup" class="C1GRIDBLK3Bclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            <!--columbarium 1 1st floor block 3 Side B-->
            <div class="C1GRIDBLK3BGrid" id="C1GRIDBLK3BGrid">
<div data-lotno="201" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">201</div>
<div data-lotno="202" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">202</div>
<div data-lotno="203" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">203</div>
<div data-lotno="204" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">204</div>
<div data-lotno="205" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">205</div>
<div data-lotno="206" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">206</div>
<div data-lotno="207" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">207</div>
<div data-lotno="208" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">208</div>
<div data-lotno="209" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">209</div>
<div data-lotno="210" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">210</div>

<div data-lotno="211" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">211</div>
<div data-lotno="212" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">212</div>
<div data-lotno="213" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">213</div>
<div data-lotno="214" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">214</div>
<div data-lotno="215" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">215</div>
<div data-lotno="216" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">216</div>
<div data-lotno="217" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">217</div>
<div data-lotno="218" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">218</div>
<div data-lotno="219" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">219</div>
<div data-lotno="220" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">220</div>

<div data-lotno="221" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">221</div>
<div data-lotno="222" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">222</div>
<div data-lotno="223" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">223</div>
<div data-lotno="224" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">224</div>
<div data-lotno="225" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">225</div>
<div data-lotno="226" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">226</div>
<div data-lotno="227" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">227</div>
<div data-lotno="228" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">228</div>
<div data-lotno="229" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">229</div>
<div data-lotno="230" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">230</div>

<div data-lotno="231" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">231</div>
<div data-lotno="232" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">232</div>
<div data-lotno="233" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">233</div>
<div data-lotno="234" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">234</div>
<div data-lotno="235" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">235</div>
<div data-lotno="236" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">236</div>
<div data-lotno="237" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">237</div>
<div data-lotno="238" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">238</div>
<div data-lotno="239" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">239</div>
<div data-lotno="240" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK3B">240</div>

            </div>
        </div>


        <div class="C1GRIDBLK4A" id="C1GRIDBLK4A"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDBLK4AclosePopup" class="C1GRIDBLK4Aclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            <!--columbarium 1 1st floor block 4 Side A-->
            <div class="C1GRIDBLK4AGrid" id="C1GRIDBLK4AGrid">
<div data-lotno="241" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">241</div>
<div data-lotno="242" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">242</div>
<div data-lotno="243" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">243</div>
<div data-lotno="244" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">244</div>
<div data-lotno="245" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">245</div>
<div data-lotno="246" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">246</div>
<div data-lotno="247" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">247</div>
<div data-lotno="248" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">248</div>
<div data-lotno="249" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">249</div>
<div data-lotno="250" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">250</div>

<div data-lotno="251" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">251</div>
<div data-lotno="252" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">252</div>
<div data-lotno="253" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">253</div>
<div data-lotno="254" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">254</div>
<div data-lotno="255" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">255</div>
<div data-lotno="256" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">256</div>
<div data-lotno="257" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">257</div>
<div data-lotno="258" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">258</div>
<div data-lotno="259" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">259</div>
<div data-lotno="260" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">260</div>

<div data-lotno="261" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">261</div>
<div data-lotno="262" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">262</div>
<div data-lotno="263" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">263</div>
<div data-lotno="264" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">264</div>
<div data-lotno="265" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">265</div>
<div data-lotno="266" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">266</div>
<div data-lotno="267" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">267</div>
<div data-lotno="268" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">268</div>
<div data-lotno="269" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">269</div>
<div data-lotno="270" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">270</div>

<div data-lotno="271" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">271</div>
<div data-lotno="272" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">272</div>
<div data-lotno="273" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">273</div>
<div data-lotno="274" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">274</div>
<div data-lotno="275" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">275</div>
<div data-lotno="276" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">276</div>
<div data-lotno="277" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">277</div>
<div data-lotno="278" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">278</div>
<div data-lotno="279" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">279</div>
<div data-lotno="280" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4A">280</div>

            </div>
        </div>

        <div class="C1GRIDBLK4B" id="C1GRIDBLK4B"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDBLK4BclosePopup" class="C1GRIDBLK4Bclosebutton">&times;</button>
            
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            <!--columbarium 1 1st floor block 4 Side B-->
            <div class="C1GRIDBLK4BGrid" id="C1GRIDBLK4BGrid">
<div data-lotno="281" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">281</div>
<div data-lotno="282" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">282</div>
<div data-lotno="283" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">283</div>
<div data-lotno="284" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">284</div>
<div data-lotno="285" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">285</div>
<div data-lotno="286" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">286</div>
<div data-lotno="287" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">287</div>
<div data-lotno="288" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">288</div>
<div data-lotno="289" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">289</div>
<div data-lotno="290" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">290</div>

<div data-lotno="291" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">291</div>
<div data-lotno="292" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">292</div>
<div data-lotno="293" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">293</div>
<div data-lotno="294" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">294</div>
<div data-lotno="295" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">295</div>
<div data-lotno="296" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">296</div>
<div data-lotno="297" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">297</div>
<div data-lotno="298" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">298</div>
<div data-lotno="299" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">299</div>
<div data-lotno="300" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">300</div>

<div data-lotno="301" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">301</div>
<div data-lotno="302" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">302</div>
<div data-lotno="303" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">303</div>
<div data-lotno="304" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">304</div>
<div data-lotno="305" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">305</div>
<div data-lotno="306" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">306</div>
<div data-lotno="307" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">307</div>
<div data-lotno="308" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">308</div>
<div data-lotno="309" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">309</div>
<div data-lotno="310" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">310</div>

<div data-lotno="311" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">311</div>
<div data-lotno="312" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">312</div>
<div data-lotno="313" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">313</div>
<div data-lotno="314" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">314</div>
<div data-lotno="315" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">315</div>
<div data-lotno="316" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">316</div>
<div data-lotno="317" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">317</div>
<div data-lotno="318" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">318</div>
<div data-lotno="319" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">319</div>
<div data-lotno="320" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1BLK4B">320</div>

            
            </div>
        </div>



          <div class="C12ndflr" id="C12ndflr"><br></tb>2nd Floor</div>

          <div class="C12nd" id="C12nd"><h3 style="color: #e9f9ef;">Columbarium 1 (2nd Floor)</h3><br><h5 style="color: #e9f9ef;">Select Block</h5> 
            <div class="C12ndflrSA" id="C12ndflrSA"><br></tb>Block 1</div>
            <div class="C12ndflrSB" id="C12ndflrSB"><br></tb>Block 2</div>
            <div class="C12ndflrblck3" id="C12ndflrblck3"><br></tb>Block 3</div>
            <div class="C12ndflrblck4" id="C12ndflrblck4"><br></tb>Block 4</div>
            <button id="C1closePopup2nd" class="C1close-button2nd">&times;</button>    
        </div>
        
        <div class="C12ndS" id="C12ndS"><h3 style="color: #e9f9ef;">Columbarium 1 (2nd floor Block 1)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>     
            <div class="C12ndflrSSA tooltip" id="C12ndflrSSA" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C12ndflrSSB tooltip" id="C12ndflrSSB" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C12ndclosePopupS" class="C12ndclosebuttonS">&times;</button>
        </div>
        <!--blk3 2nd floorsides-->
        <div class="C12ndblk3" id="C12ndblk3"><h3 style="color: #e9f9ef;">Columbarium 1 (2nd floor Block 3)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>     
            <div class="C12ndflrblk3A tooltip" id="C12ndflrblk3A" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C12ndflrblk3B tooltip" id="C12ndflrblk3B" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C12ndclosePopupblk3" class="C12ndclosebuttonblk3">&times;</button>
        </div>


        <div class="C1blk3A2ndGRID" id="C1blk3A2ndGRID"><h3 style="color: white;">Side A</h3><br>
            <button id="C1blk3A2ndGRIDclosePopup" class="C1blk3A2ndGRIDclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbrarium 1 2nd floor block 3 Side A-->

            <div class="C1GRIDblk3A2ndGrid" id="C1GRIDblk3A2ndGrid">
<div data-lotno="481" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">481</div>
<div data-lotno="482" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">482</div>
<div data-lotno="483" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">483</div>
<div data-lotno="484" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">484</div>
<div data-lotno="485" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">485</div>
<div data-lotno="486" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">486</div>
<div data-lotno="487" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">487</div>
<div data-lotno="488" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">488</div>
<div data-lotno="489" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">489</div>
<div data-lotno="490" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">490</div>

<div data-lotno="491" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">491</div>
<div data-lotno="492" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">492</div>
<div data-lotno="493" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">493</div>
<div data-lotno="494" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">494</div>
<div data-lotno="495" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">495</div>
<div data-lotno="496" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">496</div>
<div data-lotno="497" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">497</div>
<div data-lotno="498" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">498</div>
<div data-lotno="499" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">499</div>
<div data-lotno="500" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">500</div>

<div data-lotno="501" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">501</div>
<div data-lotno="502" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">502</div>
<div data-lotno="503" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">503</div>
<div data-lotno="504" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">504</div>
<div data-lotno="505" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">505</div>
<div data-lotno="506" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">506</div>
<div data-lotno="507" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">507</div>
<div data-lotno="508" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">508</div>
<div data-lotno="509" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">509</div>
<div data-lotno="510" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">510</div>

<div data-lotno="511" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">511</div>
<div data-lotno="512" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">512</div>
<div data-lotno="513" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">513</div>
<div data-lotno="514" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">514</div>
<div data-lotno="515" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">515</div>
<div data-lotno="516" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">516</div>
<div data-lotno="517" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">517</div>
<div data-lotno="518" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">518</div>
<div data-lotno="519" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">519</div>
<div data-lotno="520" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3A2nd">520</div>

            </div>
        </div>
        <div class="C1blk3B2ndGRID" id="C1blk3B2ndGRID"><h3 style="color: white;">Side B</h3><br>
            <button id="C1blk3B2ndGRIDclosePopup" class="C1blk3B2ndGRIDclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbrarium 1 2nd floor block 3 Side B-->

            <div class="C1GRIDblk3B2ndGrid" id="C1GRIDblk3B2ndGrid">
<div data-lotno="521" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">521</div>
<div data-lotno="522" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">522</div>
<div data-lotno="523" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">523</div>
<div data-lotno="524" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">524</div>
<div data-lotno="525" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">525</div>
<div data-lotno="526" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">526</div>
<div data-lotno="527" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">527</div>
<div data-lotno="528" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">528</div>
<div data-lotno="529" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">529</div>
<div data-lotno="530" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">530</div>

<div data-lotno="531" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">531</div>
<div data-lotno="532" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">532</div>
<div data-lotno="533" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">533</div>
<div data-lotno="534" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">534</div>
<div data-lotno="535" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">535</div>
<div data-lotno="536" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">536</div>
<div data-lotno="537" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">537</div>
<div data-lotno="538" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">538</div>
<div data-lotno="539" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">539</div>
<div data-lotno="540" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">540</div>

<div data-lotno="541" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">541</div>
<div data-lotno="542" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">542</div>
<div data-lotno="543" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">543</div>
<div data-lotno="544" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">544</div>
<div data-lotno="545" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">545</div>
<div data-lotno="546" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">546</div>
<div data-lotno="547" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">547</div>
<div data-lotno="548" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">548</div>
<div data-lotno="549" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">549</div>
<div data-lotno="550" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">550</div>

<div data-lotno="551" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">551</div>
<div data-lotno="552" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">552</div>
<div data-lotno="553" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">553</div>
<div data-lotno="554" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">554</div>
<div data-lotno="555" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">555</div>
<div data-lotno="556" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">556</div>
<div data-lotno="557" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">557</div>
<div data-lotno="558" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">558</div>
<div data-lotno="559" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">559</div>
<div data-lotno="560" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk3B2nd">560</div>

            </div>
        </div>


        <div class="C1blk4A2ndGRID" id="C1blk4A2ndGRID"><h3 style="color: white;">Side A</h3><br>
            <button id="C1blk4A2ndGRIDclosePopup" class="C1blk3A2ndGRIDclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbrarium 1 2nd floor block 4 Side A-->

            <div class="C1GRIDblk4A2ndGrid" id="C1GRIDblk4A2ndGrid">
<div data-lotno="561" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">561</div>
<div data-lotno="562" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">562</div>
<div data-lotno="563" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">563</div>
<div data-lotno="564" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">564</div>
<div data-lotno="565" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">565</div>
<div data-lotno="566" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">566</div>
<div data-lotno="567" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">567</div>
<div data-lotno="568" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">568</div>
<div data-lotno="569" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">569</div>
<div data-lotno="570" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">570</div>

<div data-lotno="571" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">571</div>
<div data-lotno="572" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">572</div>
<div data-lotno="573" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">573</div>
<div data-lotno="574" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">574</div>
<div data-lotno="575" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">575</div>
<div data-lotno="576" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">576</div>
<div data-lotno="577" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">577</div>
<div data-lotno="578" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">578</div>
<div data-lotno="579" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">579</div>
<div data-lotno="580" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">580</div>

<div data-lotno="581" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">581</div>
<div data-lotno="582" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">582</div>
<div data-lotno="583" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">583</div>
<div data-lotno="584" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">584</div>
<div data-lotno="585" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">585</div>
<div data-lotno="586" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">586</div>
<div data-lotno="587" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">587</div>
<div data-lotno="588" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">588</div>
<div data-lotno="589" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">589</div>
<div data-lotno="590" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">590</div>

<div data-lotno="591" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">591</div>
<div data-lotno="592" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">592</div>
<div data-lotno="593" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">593</div>
<div data-lotno="594" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">594</div>
<div data-lotno="595" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">595</div>
<div data-lotno="596" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">596</div>
<div data-lotno="597" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">597</div>
<div data-lotno="598" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">598</div>
<div data-lotno="599" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">599</div>
<div data-lotno="600" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4A2nd">600</div>

            </div>
        </div>
        <div class="C1blk4B2ndGRID" id="C1blk4B2ndGRID"><h3 style="color: white;">Side B</h3><br>
            <button id="C1blk4B2ndGRIDclosePopup" class="C1blk3B2ndGRIDclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbrarium 1 2nd floor block 4 Side B-->

            <div class="C1GRIDblk4B2ndGrid" id="C1GRIDblk4B2ndGrid">
<div data-lotno="601" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">601</div>
<div data-lotno="602" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">602</div>
<div data-lotno="603" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">603</div>
<div data-lotno="604" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">604</div>
<div data-lotno="605" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">605</div>
<div data-lotno="606" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">606</div>
<div data-lotno="607" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">607</div>
<div data-lotno="608" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">608</div>
<div data-lotno="609" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">609</div>
<div data-lotno="610" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">610</div>

<div data-lotno="611" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">611</div>
<div data-lotno="612" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">612</div>
<div data-lotno="613" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">613</div>
<div data-lotno="614" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">614</div>
<div data-lotno="615" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">615</div>
<div data-lotno="616" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">616</div>
<div data-lotno="617" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">617</div>
<div data-lotno="618" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">618</div>
<div data-lotno="619" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">619</div>
<div data-lotno="620" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">620</div>

<div data-lotno="621" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">621</div>
<div data-lotno="622" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">622</div>
<div data-lotno="623" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">623</div>
<div data-lotno="624" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">624</div>
<div data-lotno="625" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">625</div>
<div data-lotno="626" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">626</div>
<div data-lotno="627" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">627</div>
<div data-lotno="628" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">628</div>
<div data-lotno="629" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">629</div>
<div data-lotno="630" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">630</div>

<div data-lotno="631" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">631</div>
<div data-lotno="632" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">632</div>
<div data-lotno="633" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">633</div>
<div data-lotno="634" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">634</div>
<div data-lotno="635" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">635</div>
<div data-lotno="636" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">636</div>
<div data-lotno="637" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">637</div>
<div data-lotno="638" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">638</div>
<div data-lotno="639" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">639</div>
<div data-lotno="640" data-memsts="Columbarium1" data-memlot="None" class="grid-itemC1blk4B2nd">640</div>

            
            </div>
        </div>

        <div class="C12ndblk4" id="C12ndblk4"><h3 style="color: #e9f9ef;">Columbarium 1 (2nd floor Block 4)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>     
            <div class="C12ndflrblk4A tooltip" id="C12ndflrblk4A"data-tooltip="Front"><br></tb>Side A</div>
            <div class="C12ndflrblk4B tooltip" id="C12ndflrblk4B"data-tooltip="Back"><br></tb>Side B</div>
           <button id="C12ndclosePopupblk4" class="C12ndclosebuttonblk4">&times;</button>
        </div>
         
        <div class="C1GRIDS1A" id="C1GRIDS1A"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDS1AclosePopup" class="C1GRIDS1Aclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbrarium 1 2nd floor block 1 Side A-->

            <div class="C1GRIDS1AGrid" id="C1GRIDS1AGrid">
<div data-lotno="321" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">321</div>
<div data-lotno="322" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">322</div>
<div data-lotno="323" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">323</div>
<div data-lotno="324" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">324</div>
<div data-lotno="325" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">325</div>
<div data-lotno="326" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">326</div>
<div data-lotno="327" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">327</div>
<div data-lotno="328" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">328</div>
<div data-lotno="329" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">329</div>
<div data-lotno="330" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">330</div>

<div data-lotno="331" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">331</div>
<div data-lotno="332" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">332</div>
<div data-lotno="333" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">333</div>
<div data-lotno="334" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">334</div>
<div data-lotno="335" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">335</div>
<div data-lotno="336" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">336</div>
<div data-lotno="337" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">337</div>
<div data-lotno="338" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">338</div>
<div data-lotno="339" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">339</div>
<div data-lotno="340" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">340</div>

<div data-lotno="341" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">341</div>
<div data-lotno="342" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">342</div>
<div data-lotno="343" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">343</div>
<div data-lotno="344" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">344</div>
<div data-lotno="345" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">345</div>
<div data-lotno="346" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">346</div>
<div data-lotno="347" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">347</div>
<div data-lotno="348" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">348</div>
<div data-lotno="349" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">349</div>
<div data-lotno="350" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">350</div>

<div data-lotno="351" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">351</div>
<div data-lotno="352" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">352</div>
<div data-lotno="353" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">353</div>
<div data-lotno="354" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">354</div>
<div data-lotno="355" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">355</div>
<div data-lotno="356" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">356</div>
<div data-lotno="357" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">357</div>
<div data-lotno="358" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">358</div>
<div data-lotno="359" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">359</div>
<div data-lotno="360" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1A">360</div>

            </div>
        </div>
        <div class="C1GRIDS1B" id="C1GRIDS1B"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDS1BclosePopup" class="C1GRIDS1Bclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
            
        <!--Columbarium 1 2nd floor block 1 Side B-->

            <div class="C1GRIDS1BGrid" id="C1GRIDS1BGrid">
<div data-lotno="361" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">361</div>
<div data-lotno="362" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">362</div>
<div data-lotno="363" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">363</div>
<div data-lotno="364" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">364</div>
<div data-lotno="365" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">365</div>
<div data-lotno="366" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">366</div>
<div data-lotno="367" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">367</div>
<div data-lotno="368" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">368</div>
<div data-lotno="369" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">369</div>
<div data-lotno="370" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">370</div>

<div data-lotno="371" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">371</div>
<div data-lotno="372" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">372</div>
<div data-lotno="373" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">373</div>
<div data-lotno="374" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">374</div>
<div data-lotno="375" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">375</div>
<div data-lotno="376" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">376</div>
<div data-lotno="377" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">377</div>
<div data-lotno="378" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">378</div>
<div data-lotno="379" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">379</div>
<div data-lotno="380" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">380</div>

<div data-lotno="381" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">381</div>
<div data-lotno="382" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">382</div>
<div data-lotno="383" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">383</div>
<div data-lotno="384" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">384</div>
<div data-lotno="385" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">385</div>
<div data-lotno="386" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">386</div>
<div data-lotno="387" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">387</div>
<div data-lotno="388" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">388</div>
<div data-lotno="389" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">389</div>
<div data-lotno="390" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">390</div>

<div data-lotno="391" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">391</div>
<div data-lotno="392" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">392</div>
<div data-lotno="393" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">393</div>
<div data-lotno="394" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">394</div>
<div data-lotno="395" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">395</div>
<div data-lotno="396" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">396</div>
<div data-lotno="397" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">397</div>
<div data-lotno="398" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">398</div>
<div data-lotno="399" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">399</div>
<div data-lotno="400" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1S1B">400</div>

            </div>
        </div>
        

        <div class="C12ndS2" id="C12ndS2"><h3 style="color: #e9f9ef;">Columbarium 1 (2nd floor Block 2)</h3><br><h5 style="color: #e9f9ef;">Select Side</h5>
             
            <div class="C12ndS2flrSSA tooltip" id="C12ndS2flrSSA" data-tooltip="Front"><br></tb>Side A</div>
            <div class="C12ndS2flrSSB tooltip" id="C12ndS2flrSSB" data-tooltip="Back"><br></tb>Side B</div>
           <button id="C12ndclosePopupS2" class="C12ndclosebuttonS2">&times;</button>

           <div class="C1GRIDSA" id="C1GRIDSA"><h3 style="color: white;">Side A</h3><br>
            <button id="C1GRIDSAclosePopup" class="C1GRIDSAclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                <div class="legends">Legend</div>
                <div class="legendList">
                <div class="legendU Available"></div>
                <span>Available slots</span>
                </div>
            <div class="legendList">
              <div class="legendU Unavailable"></div>
              <span>Owned slots</span>
            </div>
          </div>
        <!--Columbarium 1 2nd floor block 2 side A-->

            <div class="C1GRIDSAGrid" id="C1GRIDSAGrid">
<div data-lotno="401" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">401</div>
<div data-lotno="402" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">402</div>
<div data-lotno="403" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">403</div>
<div data-lotno="404" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">404</div>
<div data-lotno="405" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">405</div>
<div data-lotno="406" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">406</div>
<div data-lotno="407" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">407</div>
<div data-lotno="408" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">408</div>
<div data-lotno="409" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">409</div>
<div data-lotno="410" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">410</div>

<div data-lotno="411" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">411</div>
<div data-lotno="412" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">412</div>
<div data-lotno="413" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">413</div>
<div data-lotno="414" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">414</div>
<div data-lotno="415" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">415</div>
<div data-lotno="416" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">416</div>
<div data-lotno="417" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">417</div>
<div data-lotno="418" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">418</div>
<div data-lotno="419" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">419</div>
<div data-lotno="420" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">420</div>

<div data-lotno="421" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">421</div>
<div data-lotno="422" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">422</div>
<div data-lotno="423" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">423</div>
<div data-lotno="424" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">424</div>
<div data-lotno="425" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">425</div>
<div data-lotno="426" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">426</div>
<div data-lotno="427" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">427</div>
<div data-lotno="428" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">428</div>
<div data-lotno="429" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">429</div>
<div data-lotno="430" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">430</div>

<div data-lotno="431" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">431</div>
<div data-lotno="432" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">432</div>
<div data-lotno="433" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">433</div>
<div data-lotno="434" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">434</div>
<div data-lotno="435" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">435</div>
<div data-lotno="436" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">436</div>
<div data-lotno="437" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">437</div>
<div data-lotno="438" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">438</div>
<div data-lotno="439" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">439</div>
<div data-lotno="440" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SA">440</div>

            
            </div>
        </div>

        <div class="C1GRIDSB" id="C1GRIDSB"><h3 style="color: white;">Side B</h3><br>
            <button id="C1GRIDSBclosePopup" class="C1GRIDSBclosebutton">&times;</button>
           
            <div class="A1lgndsSA" id="legendBox">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available slots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned slots</span>
                    </div>
                  </div>
        <!--Columbarium 1 2nd floor block 2 side B-->

            <div class="C1GRIDSBGrid" id="C1GRIDSBGrid">
<div data-lotno="441" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">441</div>
<div data-lotno="442" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">442</div>
<div data-lotno="443" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">443</div>
<div data-lotno="444" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">444</div>
<div data-lotno="445" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">445</div>
<div data-lotno="446" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">446</div>
<div data-lotno="447" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">447</div>
<div data-lotno="448" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">448</div>
<div data-lotno="449" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">449</div>
<div data-lotno="450" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">450</div>

<div data-lotno="451" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">451</div>
<div data-lotno="452" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">452</div>
<div data-lotno="453" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">453</div>
<div data-lotno="454" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">454</div>
<div data-lotno="455" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">455</div>
<div data-lotno="456" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">456</div>
<div data-lotno="457" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">457</div>
<div data-lotno="458" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">458</div>
<div data-lotno="459" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">459</div>
<div data-lotno="460" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">460</div>

<div data-lotno="461" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">461</div>
<div data-lotno="462" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">462</div>
<div data-lotno="463" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">463</div>
<div data-lotno="464" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">464</div>
<div data-lotno="465" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">465</div>
<div data-lotno="466" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">466</div>
<div data-lotno="467" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">467</div>
<div data-lotno="468" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">468</div>
<div data-lotno="469" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">469</div>
<div data-lotno="470" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">470</div>

<div data-lotno="471" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">471</div>
<div data-lotno="472" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">472</div>
<div data-lotno="473" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">473</div>
<div data-lotno="474" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">474</div>
<div data-lotno="475" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">475</div>
<div data-lotno="476" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">476</div>
<div data-lotno="477" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">477</div>
<div data-lotno="478" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">478</div>
<div data-lotno="479" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">479</div>
<div data-lotno="480" data-memsts="Columbarium1" data-memlot="Lawn Lots" class="grid-itemC1SB">480</div>

            
            </div>
        </div>
        
        
        

        </div>  
          <button id="C1closePopup" class="C1close-button">&times;</button>
        
        </div>

       
       
      
        <map name="mymap" id="mymap">
            
          <area shape="rect" coords="993,493,1377,565" href="#" title="Apartment 3"  >
          
          <area shape="rect" coords="997,677,1381,749" href="#" title="Apartment 2" >
       
          <area shape="rect" coords="997,861,1397,929" href="#" title="Apartment 1" >
          
          <area shape="rect" coords="1529,378,1903,657" href="#" title="Columbarium 2" >
         
          <area shape="rect" coords="1965,378,2338, 662" href="#" title="Columbarium 1">
         
         
          
          <div class="Colum1" id="Colum1">
            Columbarium 1
          </div>
          <div class="Colum2" id="Colum2">
            Columbarium 2
          </div>
          <div class="Apart1" id="Apart1">
            Apartment 1
          </div>
          <div class="Apart2" id="Apart2">
            Apartment 2
          </div>
          <div class="Apart3" id="Apart3">
            Apartment 3
          </div>
        
          <area shape="poly" coords="3582,559,3672,590,3722,667,3708,761,3641,815,3546,815,3474,770,3456,662,3497,599" href="#" title="Chapel" id="Paiyakan">
          <area shape="poly" coords="3582,559,3672,590,3722,667,3708,761,3641,815,3546,815,3474,770,3456,662,3497,599" href="#" title="Memorial Church" id="Church">
          <area shape="poly" coords="3286,2867,3128,2804,3028,3033,3178,3096" href="#" title="Memorial Church">
          <div class="Rafael" id="Rafael">
            St. Rafael
          </div>
          <div class="RAF" id="idRAF"><h3 style="color: white;">St. Rafael</h3><br>
            <button id="IDRAFaclosebtn" class="RAFaclosebtn">&times;</button>
            <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
            

            <div class="RAFgrid" id="RAFgrid">
            <div data-lotno="1" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">1</div>
            <div data-lotno="2" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">2</div>
            <div data-lotno="3" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">3</div>
            <div data-lotno="4" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">4</div>
            <div data-lotno="5" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">5</div>
            <div data-lotno="6" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">6</div>
            <div data-lotno="7" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">7</div>
            <div data-lotno="8" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">8</div>
            <div data-lotno="9" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">9</div>
            <div data-lotno="10" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">10</div>
    
            <div data-lotno="11" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">11</div>
            <div data-lotno="12" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">12</div>
            <div data-lotno="13" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">13</div>
            <div data-lotno="14" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">14</div>
            <div data-lotno="15" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">15</div>
            <div data-lotno="16" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">16</div>
            <div data-lotno="17" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">17</div>
            <div data-lotno="18" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">18</div>
            <div data-lotno="19" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">19</div>
            <div data-lotno="20" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">20</div>
    
            <div data-lotno="21" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">21</div>
            <div data-lotno="22" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">22</div>
            <div data-lotno="23" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">23</div>
            <div data-lotno="24" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">24</div>
            <div data-lotno="25" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">25</div>
            <div data-lotno="26" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">26</div>
            <div data-lotno="27" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">27</div>
            <div data-lotno="28" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">28</div>
            <div data-lotno="29" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">29</div>
            <div data-lotno="30" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">30</div>
    
            <div data-lotno="31" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">31</div>
            <div data-lotno="32" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">32</div>
            <div data-lotno="33" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">33</div>
            <div data-lotno="34" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">34</div>
            <div data-lotno="35" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">35</div>
            <div data-lotno="36" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">36</div>
            <div data-lotno="37" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">37</div>
            <div data-lotno="38" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">38</div>
            <div data-lotno="39" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">39</div>
            <div data-lotno="40" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">40</div>

            <div data-lotno="41" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">41</div>
            <div data-lotno="42" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">42</div>
            <div data-lotno="43" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">43</div>
            <div data-lotno="44" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">44</div>
            <div data-lotno="45" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">45</div>
            <div data-lotno="46" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">46</div>
            <div data-lotno="47" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">47</div>
            <div data-lotno="48" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">48</div>
            <div data-lotno="49" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">49</div>
            <div data-lotno="50" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">50</div>

            <div data-lotno="51" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">51</div>
            <div data-lotno="52" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">52</div>
            <div data-lotno="53" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">53</div>
            <div data-lotno="54" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">54</div>
            <div data-lotno="55" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">55</div>
            <div data-lotno="56" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">56</div>
            <div data-lotno="57" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">57</div>
            <div data-lotno="58" data-memsts="St. Rafael" data-memlot="Lawn Lots" class="grid-itemRAF">58</div>
          
            
            </div>
        </div>
        
          <area shape="rect" coords="2557,1997,3077,2233" href="#" title="St. Peter">
          <div class="Peter" id="Peter">
              St. Peter
            </div>
            
            <div class="stPeter" id="idpeter"><h3 style="color: white;">St. Peter</h3><br>
                <button id="IDpeterclosebtn" class="peterclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="petergrid" id="petergrid">
                <div data-lotno="1" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">1</div>
                <div data-lotno="2" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">2</div>
                <div data-lotno="3" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">3</div>
                <div data-lotno="4" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">4</div>
                <div data-lotno="5" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">5</div>
                <div data-lotno="6" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">6</div>
                <div data-lotno="7" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">7</div>
                <div data-lotno="8" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">8</div>
                <div data-lotno="9" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">9</div>
                <div data-lotno="10" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">10</div>
        
                <div data-lotno="11" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">11</div>
                <div data-lotno="12" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">12</div>
                <div data-lotno="13" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">13</div>
                <div data-lotno="14" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">14</div>
                <div data-lotno="15" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">15</div>
                <div data-lotno="16" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">16</div>
                <div data-lotno="17" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">17</div>
                <div data-lotno="18" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">18</div>
                <div data-lotno="19" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">19</div>
                <div data-lotno="20" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">20</div>
        
                <div data-lotno="21" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">21</div>
                <div data-lotno="22" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">22</div>
                <div data-lotno="23" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">23</div>
                <div data-lotno="24" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">24</div>
                <div data-lotno="25" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">25</div>
                <div data-lotno="26" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">26</div>
                <div data-lotno="27" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">27</div>
                <div data-lotno="28" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">28</div>
                <div data-lotno="29" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">29</div>
                <div data-lotno="30" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">30</div>
        
                <div data-lotno="31" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">31</div>
                <div data-lotno="32" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">32</div>
                <div data-lotno="33" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">33</div>
                <div data-lotno="34" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">34</div>
                <div data-lotno="35" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">35</div>
                <div data-lotno="36" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">36</div>
                <div data-lotno="37" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">37</div>
                <div data-lotno="38" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">38</div>
                <div data-lotno="39" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">39</div>
                <div data-lotno="40" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">40</div>
    
                <div data-lotno="41" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">41</div>
                <div data-lotno="42" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">42</div>
                <div data-lotno="43" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">43</div>
                <div data-lotno="44" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">44</div>
                <div data-lotno="45" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">45</div>
                <div data-lotno="46" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">46</div>
                <div data-lotno="47" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">47</div>
                <div data-lotno="48" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">48</div>
                <div data-lotno="49" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">49</div>
                <div data-lotno="50" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">50</div>
    
                <div data-lotno="51" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">51</div>
                <div data-lotno="52" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">52</div>
                <div data-lotno="53" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">53</div>
                <div data-lotno="54" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">54</div>
                <div data-lotno="55" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">55</div>
                <div data-lotno="56" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">56</div>
                <div data-lotno="57" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">57</div>
                <div data-lotno="58" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">58</div>
                <div data-lotno="59" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">59</div>
                <div data-lotno="60" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">60</div>

                <div data-lotno="61" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">61</div>
                <div data-lotno="62" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">62</div>
                <div data-lotno="63" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">63</div>
                <div data-lotno="64" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">64</div>
                <div data-lotno="65" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">65</div>
                <div data-lotno="66" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">66</div>
                <div data-lotno="67" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">67</div>
                <div data-lotno="68" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">68</div>
                <div data-lotno="69" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">69</div>
                <div data-lotno="70" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">70</div>
                
                <div data-lotno="71" data-memsts="St. Peter" data-memlot="Lawn Lots" class="grid-itempeter">71</div>
                
                </div>
               
            </div>
          <area shape="poly" coords="2542,1630,3069,1625,3105,1715,3096,1841,3114,1882,3096,1927,2547,1922" href="#" title="St. Paul">
          <div class="Paul" id="Paul">
              St. Paul
            </div>
            <div class="stPaul" id="idpaul"><h3 style="color: white;">St. Paul</h3><br>
                <button id="IDpaulclosebtn" class="paulclosebtn">&times;</button>
               
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
    
                <div class="paulgrid" id="paulgrid">
                <div data-lotno="1" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">1</div>
                <div data-lotno="2" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">2</div>
                <div data-lotno="3" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">3</div>
                <div data-lotno="4" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">4</div>
                <div data-lotno="5" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">5</div>
                <div data-lotno="6" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">6</div>
                <div data-lotno="7" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">7</div>
                <div data-lotno="8" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">8</div>
                <div data-lotno="9" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">9</div>
                <div data-lotno="10" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">10</div>
        
                <div data-lotno="11" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">11</div>
                <div data-lotno="12" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">12</div>
                <div data-lotno="13" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">13</div>
                <div data-lotno="14" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">14</div>
                <div data-lotno="15" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">15</div>
                <div data-lotno="16" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">16</div>
                <div data-lotno="17" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">17</div>
                <div data-lotno="18" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">18</div>
                <div data-lotno="19" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">19</div>
                <div data-lotno="20" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">20</div>
        
                <div data-lotno="21" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">21</div>
                <div data-lotno="22" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">22</div>
                <div data-lotno="23" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">23</div>
                <div data-lotno="24" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">24</div>
                <div data-lotno="25" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">25</div>
                <div data-lotno="26" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">26</div>
                <div data-lotno="27" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">27</div>
                <div data-lotno="28" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">28</div>
                <div data-lotno="29" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">29</div>
                <div data-lotno="30" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">30</div>
        
                <div data-lotno="31" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">31</div>
                <div data-lotno="32" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">32</div>
                <div data-lotno="33" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">33</div>
                <div data-lotno="34" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">34</div>
                <div data-lotno="35" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">35</div>
                <div data-lotno="36" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">36</div>
                <div data-lotno="37" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">37</div>
                <div data-lotno="38" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">38</div>
                <div data-lotno="39" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">39</div>
                <div data-lotno="40" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">40</div>
    
                <div data-lotno="41" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">41</div>
                <div data-lotno="42" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">42</div>
                <div data-lotno="43" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">43</div>
                <div data-lotno="44" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">44</div>
                <div data-lotno="45" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">45</div>
                <div data-lotno="46" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">46</div>
                <div data-lotno="47" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">47</div>
                <div data-lotno="48" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">48</div>
                <div data-lotno="49" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">49</div>
                <div data-lotno="50" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">50</div>
    
                <div data-lotno="51" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">51</div>
                <div data-lotno="52" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">52</div>
                <div data-lotno="53" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">53</div>
                <div data-lotno="54" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">54</div>
                <div data-lotno="55" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">55</div>
                <div data-lotno="56" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">56</div>
                <div data-lotno="57" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">57</div>
                <div data-lotno="58" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">58</div>
                <div data-lotno="59" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">59</div>
                <div data-lotno="60" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">60</div>

                <div data-lotno="61" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">61</div>
                <div data-lotno="62" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">62</div>
                <div data-lotno="63" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">63</div>
                <div data-lotno="64" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">64</div>
                <div data-lotno="65" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">65</div>
                <div data-lotno="66" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">66</div>
                <div data-lotno="67" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">67</div>
                <div data-lotno="68" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">68</div>
                <div data-lotno="69" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">69</div>
                <div data-lotno="70" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">70</div>
                
                <div data-lotno="71" data-memsts="St. Paul" data-memlot="Lawn Lots" class="grid-itempaul">71</div>
                </div>
            </div>
          <area shape="rect" coords="2681,197,3065,929" href="#" title="St. Jude" >
          <div class="Jude" id="Jude">
              St. Jude
            </div>
            <div class="stJude" id="idjude"><h3 style="color: white;">St. Jude</h3><br>
                <button id="IDjudeclosebtn" class="judeclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="judegrid" id="judegrid">
                    <div data-lotno="1" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">1</div>
                    <div data-lotno="2" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">2</div>
                    <div data-lotno="3" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">3</div>
                    <div data-lotno="4" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">4</div>
                    <div data-lotno="5" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">5</div>
                    <div data-lotno="6" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">6</div>
                    <div data-lotno="7" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">7</div>
                    <div data-lotno="8" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">8</div>
                    <div data-lotno="9" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">9</div>
                    <div data-lotno="10" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">10</div>
                
                    <div data-lotno="11" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">11</div>
                    <div data-lotno="12" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">12</div>
                    <div data-lotno="13" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">13</div>
                    <div data-lotno="14" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">14</div>
                    <div data-lotno="15" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">15</div>
                    <div data-lotno="16" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">16</div>
                    <div data-lotno="17" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">17</div>
                    <div data-lotno="18" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">18</div>
                    <div data-lotno="19" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">19</div>
                    <div data-lotno="20" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">20</div>
                
                    <div data-lotno="21" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">21</div>
                    <div data-lotno="22" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">22</div>
                    <div data-lotno="23" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">23</div>
                    <div data-lotno="24" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">24</div>
                    <div data-lotno="25" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">25</div>
                    <div data-lotno="26" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">26</div>
                    <div data-lotno="27" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">27</div>
                    <div data-lotno="28" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">28</div>
                    <div data-lotno="29" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">29</div>
                    <div data-lotno="30" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">30</div>
                
                    <div data-lotno="31" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">31</div>
                    <div data-lotno="32" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">32</div>
                    <div data-lotno="33" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">33</div>
                    <div data-lotno="34" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">34</div>
                    <div data-lotno="35" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">35</div>
                    <div data-lotno="36" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">36</div>
                    <div data-lotno="37" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">37</div>
                    <div data-lotno="38" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">38</div>
                    <div data-lotno="39" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">39</div>
                    <div data-lotno="40" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">40</div>
                
                    <div data-lotno="41" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">41</div>
                    <div data-lotno="42" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">42</div>
                    <div data-lotno="43" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">43</div>
                    <div data-lotno="44" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">44</div>
                    <div data-lotno="45" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">45</div>
                    <div data-lotno="46" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">46</div>
                    <div data-lotno="47" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">47</div>
                    <div data-lotno="48" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">48</div>
                    <div data-lotno="49" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">49</div>
                    <div data-lotno="50" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">50</div>
                
                    <div data-lotno="51" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">51</div>
                    <div data-lotno="52" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">52</div>
                    <div data-lotno="53" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">53</div>
                    <div data-lotno="54" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">54</div>
                    <div data-lotno="55" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">55</div>
                    <div data-lotno="56" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">56</div>
                    <div data-lotno="57" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">57</div>
                    <div data-lotno="58" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">58</div>
                    <div data-lotno="59" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">59</div>
                    <div data-lotno="60" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">60</div>
                
                    <div data-lotno="61" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">61</div>
                    <div data-lotno="62" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">62</div>
                    <div data-lotno="63" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">63</div>
                    <div data-lotno="64" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">64</div>
                    <div data-lotno="65" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">65</div>
                    <div data-lotno="66" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">66</div>
                    <div data-lotno="67" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">67</div>
                    <div data-lotno="68" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">68</div>
                    <div data-lotno="69" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">69</div>
                    <div data-lotno="70" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">70</div>
                
                    <div data-lotno="71" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">71</div>
                    <div data-lotno="72" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">72</div>
                    <div data-lotno="73" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">73</div>
                    <div data-lotno="74" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">74</div>
                    <div data-lotno="75" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">75</div>
                    <div data-lotno="76" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">76</div>
                    <div data-lotno="77" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">77</div>
                    <div data-lotno="78" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">78</div>
                    <div data-lotno="79" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">79</div>
                    <div data-lotno="80" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">80</div>
                
                    <div data-lotno="81" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">81</div>
                    <div data-lotno="82" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">82</div>
                    <div data-lotno="83" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">83</div>
                    <div data-lotno="84" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">84</div>
                    <div data-lotno="85" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">85</div>
                    <div data-lotno="86" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">86</div>
                    <div data-lotno="87" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">87</div>
                    <div data-lotno="88" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">88</div>
                    <div data-lotno="89" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">89</div>
                    <div data-lotno="90" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">90</div>
                
                    <div data-lotno="91" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">91</div>
                    <div data-lotno="92" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">92</div>
                    <div data-lotno="93" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">93</div>
                    <div data-lotno="94" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">94</div>
                    <div data-lotno="95" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">95</div>
                    <div data-lotno="96" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">96</div>
                    <div data-lotno="97" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">97</div>
                    <div data-lotno="98" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">98</div>
                    <div data-lotno="99" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">99</div>
                    <div data-lotno="100" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">100</div>
                
                    <div data-lotno="101" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">101</div>
                    <div data-lotno="102" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">102</div>
                    <div data-lotno="103" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">103</div>
                    <div data-lotno="104" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">104</div>
                    <div data-lotno="105" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">105</div>
                    <div data-lotno="106" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">106</div>
                    <div data-lotno="107" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">107</div>
                    <div data-lotno="108" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">108</div>
                    <div data-lotno="109" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">109</div>
                    <div data-lotno="110" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">110</div>
                
                    <div data-lotno="111" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">111</div>
                    <div data-lotno="112" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">112</div>
                    <div data-lotno="113" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">113</div>
                    <div data-lotno="114" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">114</div>
                    <div data-lotno="115" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">115</div>
                    <div data-lotno="116" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">116</div>
                    <div data-lotno="117" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">117</div>
                    <div data-lotno="118" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">118</div>
                    <div data-lotno="119" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">119</div>
                    <div data-lotno="120" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">120</div>
                
                    <div data-lotno="121" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">121</div>
                    <div data-lotno="122" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">122</div>
                    <div data-lotno="123" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">123</div>
                    <div data-lotno="124" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">124</div>
                    <div data-lotno="125" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">125</div>
                    <div data-lotno="126" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">126</div>
                    <div data-lotno="127" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">127</div>
                    <div data-lotno="128" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">128</div>
                    <div data-lotno="129" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">129</div>
                    <div data-lotno="130" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">130</div>
                
                    <div data-lotno="131" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">131</div>
                    <div data-lotno="132" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">132</div>
                    <div data-lotno="133" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">133</div>
                    <div data-lotno="134" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">134</div>
                    <div data-lotno="135" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">135</div>
                    <div data-lotno="136" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">136</div>
                    <div data-lotno="137" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">137</div>
                    <div data-lotno="138" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">138</div>
                    <div data-lotno="139" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">139</div>
                    <div data-lotno="140" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">140</div>
                
                    <div data-lotno="141" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">141</div>
                    <div data-lotno="142" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">142</div>
                    <div data-lotno="143" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">143</div>
                    <div data-lotno="144" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">144</div>
                    <div data-lotno="145" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">145</div>
                    <div data-lotno="146" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">146</div>
                    <div data-lotno="147" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">147</div>
                    <div data-lotno="148" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">148</div>
                    <div data-lotno="149" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">149</div>
                    <div data-lotno="150" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">150</div>
                
                    <div data-lotno="151" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">151</div>
                    <div data-lotno="152" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">152</div>
                    <div data-lotno="153" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">153</div>
                    <div data-lotno="154" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">154</div>
                    <div data-lotno="155" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">155</div>
                    <div data-lotno="156" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">156</div>
                    <div data-lotno="157" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">157</div>
                    <div data-lotno="158" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">158</div>
                    <div data-lotno="159" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">159</div>
                    <div data-lotno="160" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">160</div>
                
                    <div data-lotno="161" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">161</div>
                    <div data-lotno="162" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">162</div>
                    <div data-lotno="163" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">163</div>
                    <div data-lotno="164" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">164</div>
                    <div data-lotno="165" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">165</div>
                    <div data-lotno="166" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">166</div>
                    <div data-lotno="167" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">167</div>
                    <div data-lotno="168" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">168</div>
                    <div data-lotno="169" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">169</div>
                    <div data-lotno="170" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">170</div>
                
                    <div data-lotno="171" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">171</div>
                    <div data-lotno="172" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">172</div>
                    <div data-lotno="173" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">173</div>
                    <div data-lotno="174" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">174</div>
                    <div data-lotno="175" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">175</div>
                    <div data-lotno="176" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">176</div>
                    <div data-lotno="177" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">177</div>
                    <div data-lotno="178" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">178</div>
                    <div data-lotno="179" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">179</div>
                    <div data-lotno="180" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">180</div>
                
                    <div data-lotno="181" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">181</div>
                    <div data-lotno="182" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">182</div>
                    <div data-lotno="183" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">183</div>
                    <div data-lotno="184" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">184</div>
                    <div data-lotno="185" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">185</div>
                    <div data-lotno="186" data-memsts="St. Jude" data-memlot="Lawn Lots" class="grid-itemjude">186</div>
                    
                                </div>
                </div>

          <area shape="poly" coords="3132,181,3483,176,3483,482,3371,613,3366,757,3362,824,3254,901,3132,932" href="#" title="St. John">
          <div class="John" id="John">
              St. John
            </div>
            <div class="stJohn" id="idjohn"><h3 style="color: white;">St. John</h3><br>
                <button id="IDjohnclosebtn" class="johnclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="johngrid" id="johngrid">
                    <div data-lotno="1" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">1</div>
        <div data-lotno="2" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">2</div>
        <div data-lotno="3" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">3</div>
        <div data-lotno="4" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">4</div>
        <div data-lotno="5" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">5</div>
        <div data-lotno="6" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">6</div>
        <div data-lotno="7" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">7</div>
        <div data-lotno="8" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">8</div>
        <div data-lotno="9" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">9</div>
        <div data-lotno="10" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">10</div>
    
        <div data-lotno="11" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">11</div>
        <div data-lotno="12" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">12</div>
        <div data-lotno="13" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">13</div>
        <div data-lotno="14" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">14</div>
        <div data-lotno="15" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">15</div>
        <div data-lotno="16" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">16</div>
        <div data-lotno="17" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">17</div>
        <div data-lotno="18" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">18</div>
        <div data-lotno="19" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">19</div>
        <div data-lotno="20" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">20</div>
    
        <div data-lotno="21" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">21</div>
        <div data-lotno="22" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">22</div>
        <div data-lotno="23" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">23</div>
        <div data-lotno="24" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">24</div>
        <div data-lotno="25" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">25</div>
        <div data-lotno="26" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">26</div>
        <div data-lotno="27" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">27</div>
        <div data-lotno="28" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">28</div>
        <div data-lotno="29" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">29</div>
        <div data-lotno="30" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">30</div>
    
        <div data-lotno="31" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">31</div>
        <div data-lotno="32" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">32</div>
        <div data-lotno="33" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">33</div>
        <div data-lotno="34" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">34</div>
        <div data-lotno="35" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">35</div>
        <div data-lotno="36" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">36</div>
        <div data-lotno="37" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">37</div>
        <div data-lotno="38" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">38</div>
        <div data-lotno="39" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">39</div>
        <div data-lotno="40" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">40</div>
    
        <div data-lotno="41" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">41</div>
        <div data-lotno="42" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">42</div>
        <div data-lotno="43" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">43</div>
        <div data-lotno="44" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">44</div>
        <div data-lotno="45" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">45</div>
        <div data-lotno="46" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">46</div>
        <div data-lotno="47" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">47</div>
        <div data-lotno="48" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">48</div>
        <div data-lotno="49" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">49</div>
        <div data-lotno="50" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">50</div>
    
        <div data-lotno="51" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">51</div>
        <div data-lotno="52" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">52</div>
        <div data-lotno="53" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">53</div>
        <div data-lotno="54" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">54</div>
        <div data-lotno="55" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">55</div>
        <div data-lotno="56" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">56</div>
        <div data-lotno="57" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">57</div>
        <div data-lotno="58" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">58</div>
        <div data-lotno="59" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">59</div>
        <div data-lotno="60" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">60</div>
    
        <div data-lotno="61" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">61</div>
        <div data-lotno="62" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">62</div>
        <div data-lotno="63" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">63</div>
        <div data-lotno="64" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">64</div>
        <div data-lotno="65" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">65</div>
        <div data-lotno="66" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">66</div>
        <div data-lotno="67" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">67</div>
        <div data-lotno="68" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">68</div>
        <div data-lotno="69" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">69</div>
        <div data-lotno="70" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">70</div>
    
        <div data-lotno="71" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">71</div>
        <div data-lotno="72" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">72</div>
        <div data-lotno="73" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">73</div>
        <div data-lotno="74" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">74</div>
        <div data-lotno="75" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">75</div>
        <div data-lotno="76" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">76</div>
        <div data-lotno="77" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">77</div>
        <div data-lotno="78" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">78</div>
        <div data-lotno="79" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">79</div>
        <div data-lotno="80" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">80</div>
    
        <div data-lotno="81" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">81</div>
        <div data-lotno="82" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">82</div>
        <div data-lotno="83" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">83</div>
        <div data-lotno="84" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">84</div>
        <div data-lotno="85" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">85</div>
        <div data-lotno="86" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">86</div>
        <div data-lotno="87" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">87</div>
        <div data-lotno="88" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">88</div>
        <div data-lotno="89" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">89</div>
        <div data-lotno="90" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">90</div>
    
        <div data-lotno="91" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">91</div>
        <div data-lotno="92" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">92</div>
        <div data-lotno="93" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">93</div>
        <div data-lotno="94" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">94</div>
        <div data-lotno="95" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">95</div>
        <div data-lotno="96" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">96</div>
        <div data-lotno="97" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">97</div>
        <div data-lotno="98" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">98</div>
        <div data-lotno="99" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">99</div>
        <div data-lotno="100" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">100</div>
    
        <div data-lotno="101" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">101</div>
        <div data-lotno="102" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">102</div>
        <div data-lotno="103" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">103</div>
        <div data-lotno="104" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">104</div>
        <div data-lotno="105" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">105</div>
        <div data-lotno="106" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">106</div>
        <div data-lotno="107" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">107</div>
        <div data-lotno="108" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">108</div>
        <div data-lotno="109" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">109</div>
        <div data-lotno="110" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">110</div>
    
        <div data-lotno="111" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">111</div>
        <div data-lotno="112" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">112</div>
        <div data-lotno="113" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">113</div>
        <div data-lotno="114" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">114</div>
        <div data-lotno="115" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">115</div>
        <div data-lotno="116" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">116</div>
        <div data-lotno="117" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">117</div>
        <div data-lotno="118" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">118</div>
        <div data-lotno="119" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">119</div>
        <div data-lotno="120" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">120</div>
    
        <div data-lotno="121" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">121</div>
        <div data-lotno="122" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">122</div>
        <div data-lotno="123" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">123</div>
        <div data-lotno="124" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">124</div>
        <div data-lotno="125" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">125</div>
        <div data-lotno="126" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">126</div>
        <div data-lotno="127" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">127</div>
        <div data-lotno="128" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">128</div>
        <div data-lotno="129" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">129</div>
        <div data-lotno="130" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">130</div>
    
        <div data-lotno="131" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">131</div>
        <div data-lotno="132" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">132</div>
        <div data-lotno="133" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">133</div>
        <div data-lotno="134" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">134</div>
        <div data-lotno="135" data-memsts="St. John" data-memlot="Lawn Lots" class="grid-itemjohn">135</div>
                    </div>
            </div>
            <area shape="poly" coords="3533,185,4046,190,4032,671,3798,689,3744,541,3605,473,3528,473" href="#" title="St. Joseph">
          <div class="Joseph" id="Joseph">
              St. Joseph
            </div>
            <div class="stJoseph" id="idjoseph"><h3 style="color: white;">St. Joseph</h3><br>
                <button id="IDjosephclosebtn" class="josephclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="josephgrid" id="josephgrid">
                    <div data-lotno="1" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">1</div>
    <div data-lotno="2" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">2</div>
    <div data-lotno="3" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">3</div>
    <div data-lotno="4" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">4</div>
    <div data-lotno="5" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">5</div>
    <div data-lotno="6" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">6</div>
    <div data-lotno="7" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">7</div>
    <div data-lotno="8" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">8</div>
    <div data-lotno="9" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">9</div>
    <div data-lotno="10" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">10</div>
    
    <div data-lotno="11" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">11</div>
    <div data-lotno="12" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">12</div>
    <div data-lotno="13" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">13</div>
    <div data-lotno="14" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">14</div>
    <div data-lotno="15" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">15</div>
    <div data-lotno="16" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">16</div>
    <div data-lotno="17" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">17</div>
    <div data-lotno="18" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">18</div>
    <div data-lotno="19" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">19</div>
    <div data-lotno="20" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">20</div>
    
    <div data-lotno="21" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">21</div>
    <div data-lotno="22" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">22</div>
    <div data-lotno="23" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">23</div>
    <div data-lotno="24" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">24</div>
    <div data-lotno="25" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">25</div>
    <div data-lotno="26" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">26</div>
    <div data-lotno="27" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">27</div>
    <div data-lotno="28" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">28</div>
    <div data-lotno="29" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">29</div>
    <div data-lotno="30" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">30</div>
    
    <div data-lotno="31" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">31</div>
    <div data-lotno="32" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">32</div>
    <div data-lotno="33" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">33</div>
    <div data-lotno="34" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">34</div>
    <div data-lotno="35" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">35</div>
    <div data-lotno="36" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">36</div>
    <div data-lotno="37" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">37</div>
    <div data-lotno="38" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">38</div>
    <div data-lotno="39" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">39</div>
    <div data-lotno="40" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">40</div>
    <!-- Developers: Backend Developer: Michael Enoza, Frontend Developer: Kyle Ambat -->
    <div data-lotno="41" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">41</div>
    <div data-lotno="42" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">42</div>
    <div data-lotno="43" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">43</div>
    <div data-lotno="44" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">44</div>
    <div data-lotno="45" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">45</div>
    <div data-lotno="46" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">46</div>
    <div data-lotno="47" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">47</div>
    <div data-lotno="48" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">48</div>
    <div data-lotno="49" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">49</div>
    <div data-lotno="50" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">50</div>
    
    <div data-lotno="51" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">51</div>
    <div data-lotno="52" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">52</div>
    <div data-lotno="53" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">53</div>
    <div data-lotno="54" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">54</div>
    <div data-lotno="55" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">55</div>
    <div data-lotno="56" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">56</div>
    <div data-lotno="57" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">57</div>
    <div data-lotno="58" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">58</div>
    <div data-lotno="59" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">59</div>
    <div data-lotno="60" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">60</div>
    
    <div data-lotno="61" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">61</div>
    <div data-lotno="62" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">62</div>
    <div data-lotno="63" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">63</div>
    <div data-lotno="64" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">64</div>
    <div data-lotno="65" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">65</div>
    <div data-lotno="66" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">66</div>
    <div data-lotno="67" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">67</div>
    <div data-lotno="68" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">68</div>
    <div data-lotno="69" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">69</div>
    <div data-lotno="70" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">70</div>
    
    <div data-lotno="71" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">71</div>
    <div data-lotno="72" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">72</div>
    <div data-lotno="73" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">73</div>
    <div data-lotno="74" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">74</div>
    <div data-lotno="75" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">75</div>
    <div data-lotno="76" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">76</div>
    <div data-lotno="77" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">77</div>
    <div data-lotno="78" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">78</div>
    <div data-lotno="79" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">79</div>
    <div data-lotno="80" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">80</div>
    
    <div data-lotno="81" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">81</div>
    <div data-lotno="82" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">82</div>
    <div data-lotno="83" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">83</div>
    <div data-lotno="84" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">84</div>
    <div data-lotno="85" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">85</div>
    <div data-lotno="86" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">86</div>
    <div data-lotno="87" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">87</div>
    <div data-lotno="88" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">88</div>
    <div data-lotno="89" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">89</div>
    <div data-lotno="90" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">90</div>
    
    <div data-lotno="91" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">91</div>
    <div data-lotno="92" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">92</div>
    <div data-lotno="93" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">93</div>
    <div data-lotno="94" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">94</div>
    <div data-lotno="95" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">95</div>
    <div data-lotno="96" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">96</div>
    <div data-lotno="97" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">97</div>
    <div data-lotno="98" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">98</div>
    <div data-lotno="99" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">99</div>
    <div data-lotno="100" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">100</div>
    
    <div data-lotno="101" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">101</div>
    <div data-lotno="102" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">102</div>
    <div data-lotno="103" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">103</div>
    <div data-lotno="104" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">104</div>
    <div data-lotno="105" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">105</div>
    <div data-lotno="106" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">106</div>
    <div data-lotno="107" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">107</div>
    <div data-lotno="108" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">108</div>
    <div data-lotno="109" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">109</div>
    <div data-lotno="110" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">110</div>
    
    <div data-lotno="111" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">111</div>
    <div data-lotno="112" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">112</div>
    <div data-lotno="113" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">113</div>
    <div data-lotno="114" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">114</div>
    <div data-lotno="115" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">115</div>
    <div data-lotno="116" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">116</div>
    <div data-lotno="117" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">117</div>
    <div data-lotno="118" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">118</div>
    <div data-lotno="119" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">119</div>
    <div data-lotno="120" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">120</div>
    
    <div data-lotno="121" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">121</div>
    <div data-lotno="122" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">122</div>
    <div data-lotno="123" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">123</div>
    <div data-lotno="124" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">124</div>
    <div data-lotno="125" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">125</div>
    <div data-lotno="126" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">126</div>
    <div data-lotno="127" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">127</div>
    <div data-lotno="128" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">128</div>
    <div data-lotno="129" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">129</div>
    <div data-lotno="130" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">130</div>
    
    <div data-lotno="131" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">131</div>
    <div data-lotno="132" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">132</div>
    <div data-lotno="133" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">133</div>
    <div data-lotno="134" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">134</div>
    <div data-lotno="135" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">135</div>
    <div data-lotno="136" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">136</div>
    <div data-lotno="137" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">137</div>
    <div data-lotno="138" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">138</div>
    <div data-lotno="139" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">139</div>
    <div data-lotno="140" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">140</div>
    
    <div data-lotno="141" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">141</div>
    <div data-lotno="142" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">142</div>
    <div data-lotno="143" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">143</div>
    <div data-lotno="144" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">144</div>
    <div data-lotno="145" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">145</div>
    <div data-lotno="146" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">146</div>
    <div data-lotno="147" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">147</div>
    <div data-lotno="148" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">148</div>
    <div data-lotno="149" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">149</div>
    <div data-lotno="150" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">150</div>
    
    <div data-lotno="151" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">151</div>
    <div data-lotno="152" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">152</div>
    <div data-lotno="153" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">153</div>
    <div data-lotno="154" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">154</div>
    <div data-lotno="155" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">155</div>
    <div data-lotno="156" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">156</div>
    <div data-lotno="157" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">157</div>
    <div data-lotno="158" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">158</div>
    <div data-lotno="159" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">159</div>
    <div data-lotno="160" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">160</div>
    
    <div data-lotno="161" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">161</div>
    <div data-lotno="162" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">162</div>
    <div data-lotno="163" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">163</div>
    <div data-lotno="164" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">164</div>
    <div data-lotno="165" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">165</div>
    <div data-lotno="166" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">166</div>
    <div data-lotno="167" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">167</div>
    <div data-lotno="168" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">168</div>
    <div data-lotno="169" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">169</div>
    <div data-lotno="170" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">170</div>
    
    <div data-lotno="171" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">171</div>
    <div data-lotno="172" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">172</div>
    <div data-lotno="173" data-memsts="St. Joseph" data-memlot="Lawn Lots" class="grid-itemjoseph">173</div>
    
                    </div>
            </div>
          <area shape="poly" coords="4122,181,5050,185,4834,676,4122,671" href="#" title="St. James">
          <div class="James" id="James">
            St. James
          </div>
          <div class="stJames" id="idjames"><h3 style="color: white;">St. James</h3><br>
            <button id="IDjamesclosebtn" class="jamesclosebtn">&times;</button>
            <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
            <div class="jamesgrid" id="jamesgrid">
                <div data-lotno="1" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">1</div>
    <div data-lotno="2" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">2</div>
    <div data-lotno="3" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">3</div>
    <div data-lotno="4" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">4</div>
    <div data-lotno="5" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">5</div>
    <div data-lotno="6" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">6</div>
    <div data-lotno="7" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">7</div>
    <div data-lotno="8" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">8</div>
    <div data-lotno="9" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">9</div>
    <div data-lotno="10" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">10</div>
    
    <div data-lotno="11" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">11</div>
    <div data-lotno="12" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">12</div>
    <div data-lotno="13" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">13</div>
    <div data-lotno="14" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">14</div>
    <div data-lotno="15" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">15</div>
    <div data-lotno="16" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">16</div>
    <div data-lotno="17" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">17</div>
    <div data-lotno="18" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">18</div>
    <div data-lotno="19" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">19</div>
    <div data-lotno="20" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">20</div>
    
    <div data-lotno="21" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">21</div>
    <div data-lotno="22" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">22</div>
    <div data-lotno="23" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">23</div>
    <div data-lotno="24" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">24</div>
    <div data-lotno="25" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">25</div>
    <div data-lotno="26" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">26</div>
    <div data-lotno="27" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">27</div>
    <div data-lotno="28" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">28</div>
    <div data-lotno="29" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">29</div>
    <div data-lotno="30" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">30</div>
    
    <div data-lotno="31" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">31</div>
    <div data-lotno="32" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">32</div>
    <div data-lotno="33" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">33</div>
    <div data-lotno="34" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">34</div>
    <div data-lotno="35" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">35</div>
    <div data-lotno="36" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">36</div>
    <div data-lotno="37" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">37</div>
    <div data-lotno="38" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">38</div>
    <div data-lotno="39" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">39</div>
    <div data-lotno="40" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">40</div>
    
    <div data-lotno="41" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">41</div>
    <div data-lotno="42" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">42</div>
    <div data-lotno="43" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">43</div>
    <div data-lotno="44" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">44</div>
    <div data-lotno="45" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">45</div>
    <div data-lotno="46" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">46</div>
    <div data-lotno="47" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">47</div>
    <div data-lotno="48" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">48</div>
    <div data-lotno="49" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">49</div>
    <div data-lotno="50" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">50</div>
    
    <div data-lotno="51" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">51</div>
    <div data-lotno="52" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">52</div>
    <div data-lotno="53" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">53</div>
    <div data-lotno="54" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">54</div>
    <div data-lotno="55" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">55</div>
    <div data-lotno="56" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">56</div>
    <div data-lotno="57" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">57</div>
    <div data-lotno="58" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">58</div>
    <div data-lotno="59" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">59</div>
    <div data-lotno="60" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">60</div>
    
    <div data-lotno="61" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">61</div>
    <div data-lotno="62" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">62</div>
    <div data-lotno="63" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">63</div>
    <div data-lotno="64" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">64</div>
    <div data-lotno="65" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">65</div>
    <div data-lotno="66" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">66</div>
    <div data-lotno="67" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">67</div>
    <div data-lotno="68" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">68</div>
    <div data-lotno="69" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">69</div>
    <div data-lotno="70" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">70</div>
    
    <div data-lotno="71" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">71</div>
    <div data-lotno="72" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">72</div>
    <div data-lotno="73" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">73</div>
    <div data-lotno="74" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">74</div>
    <div data-lotno="75" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">75</div>
    <div data-lotno="76" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">76</div>
    <div data-lotno="77" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">77</div>
    <div data-lotno="78" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">78</div>
    <div data-lotno="79" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">79</div>
    <div data-lotno="80" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">80</div>
    
    <div data-lotno="81" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">81</div>
    <div data-lotno="82" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">82</div>
    <div data-lotno="83" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">83</div>
    <div data-lotno="84" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">84</div>
    <div data-lotno="85" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">85</div>
    <div data-lotno="86" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">86</div>
    <div data-lotno="87" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">87</div>
    <div data-lotno="88" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">88</div>
    <div data-lotno="89" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">89</div>
    <div data-lotno="90" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">90</div>
    
    <div data-lotno="91" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">91</div>
    <div data-lotno="92" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">92</div>
    <div data-lotno="93" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">93</div>
    <div data-lotno="94" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">94</div>
    <div data-lotno="95" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">95</div>
    <div data-lotno="96" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">96</div>
    <div data-lotno="97" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">97</div>
    <div data-lotno="98" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">98</div>
    <div data-lotno="99" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">99</div>
    <div data-lotno="100" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">100</div>
    
    <div data-lotno="101" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">101</div>
    <div data-lotno="102" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">102</div>
    <div data-lotno="103" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">103</div>
    <div data-lotno="104" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">104</div>
    <div data-lotno="105" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">105</div>
    <div data-lotno="106" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">106</div>
    <div data-lotno="107" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">107</div>
    <div data-lotno="108" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">108</div>
    <div data-lotno="109" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">109</div>
    <div data-lotno="110" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">110</div>
    
    <div data-lotno="111" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">111</div>
    <div data-lotno="112" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">112</div>
    <div data-lotno="113" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">113</div>
    <div data-lotno="114" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">114</div>
    <div data-lotno="115" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">115</div>
    <div data-lotno="116" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">116</div>
    <div data-lotno="117" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">117</div>
    <div data-lotno="118" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">118</div>
    <div data-lotno="119" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">119</div>
    <div data-lotno="120" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">120</div>
    
    <div data-lotno="121" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">121</div>
    <div data-lotno="122" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">122</div>
    <div data-lotno="123" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">123</div>
    <div data-lotno="124" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">124</div>
    <div data-lotno="125" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">125</div>
    <div data-lotno="126" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">126</div>
    <div data-lotno="127" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">127</div>
    <div data-lotno="128" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">128</div>
    <div data-lotno="129" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">129</div>
    <div data-lotno="130" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">130</div>
    
    <div data-lotno="131" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">131</div>
    <div data-lotno="132" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">132</div>
    <div data-lotno="133" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">133</div>
    <div data-lotno="134" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">134</div>
    <div data-lotno="135" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">135</div>
    <div data-lotno="136" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">136</div>
    <div data-lotno="137" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">137</div>
    <div data-lotno="138" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">138</div>
    <div data-lotno="139" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">139</div>
    <div data-lotno="140" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">140</div>
    
    <div data-lotno="141" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">141</div>
    <div data-lotno="142" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">142</div>
    <div data-lotno="143" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">143</div>
    <div data-lotno="144" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">144</div>
    <div data-lotno="145" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">145</div>
    <div data-lotno="146" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">146</div>
    <div data-lotno="147" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">147</div>
    <div data-lotno="148" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">148</div>
    <div data-lotno="149" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">149</div>
    <div data-lotno="150" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">150</div>
    
    <div data-lotno="151" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">151</div>
    <div data-lotno="152" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">152</div>
    <div data-lotno="153" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">153</div>
    <div data-lotno="154" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">154</div>
    <div data-lotno="155" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">155</div>
    <div data-lotno="156" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">156</div>
    <div data-lotno="157" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">157</div>
    <div data-lotno="158" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">158</div>
    <div data-lotno="159" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">159</div>
    <div data-lotno="160" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">160</div>
    
    <div data-lotno="161" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">161</div>
    <div data-lotno="162" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">162</div>
    <div data-lotno="163" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">163</div>
    <div data-lotno="164" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">164</div>
    <div data-lotno="165" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">165</div>
    <div data-lotno="166" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">166</div>
    <div data-lotno="167" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">167</div>
    <div data-lotno="168" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">168</div>
    <div data-lotno="169" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">169</div>
    <div data-lotno="170" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">170</div>
    
    <div data-lotno="171" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">171</div>
    <div data-lotno="172" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">172</div>
    <div data-lotno="173" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">173</div>
    <div data-lotno="174" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">174</div>
    <div data-lotno="175" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">175</div>
    <div data-lotno="176" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">176</div>
    <div data-lotno="177" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">177</div>
    <div data-lotno="178" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">178</div>
    <div data-lotno="179" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">179</div>
    <div data-lotno="180" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">180</div>
    
    <div data-lotno="181" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">181</div>
    <div data-lotno="182" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">182</div>
    <div data-lotno="183" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">183</div>
    <div data-lotno="184" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">184</div>
    <div data-lotno="185" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">185</div>
    <div data-lotno="186" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">186</div>
    <div data-lotno="187" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">187</div>
    <div data-lotno="188" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">188</div>
    <div data-lotno="189" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">189</div>
    <div data-lotno="190" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">190</div>
    
    <div data-lotno="191" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">191</div>
    <div data-lotno="192" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">192</div>
    <div data-lotno="193" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">193</div>
    <div data-lotno="194" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">194</div>
    <div data-lotno="195" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">195</div>
    <div data-lotno="196" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">196</div>
    <div data-lotno="197" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">197</div>
    <div data-lotno="198" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">198</div>
    <div data-lotno="199" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">199</div>
    <div data-lotno="200" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">200</div>
    
    <div data-lotno="201" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">201</div>
    <div data-lotno="202" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">202</div>
    <div data-lotno="203" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">203</div>
    <div data-lotno="204" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">204</div>
    <div data-lotno="205" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">205</div>
    <div data-lotno="206" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">206</div>
    <div data-lotno="207" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">207</div>
    <div data-lotno="208" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">208</div>
    <div data-lotno="209" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">209</div>
    <div data-lotno="210" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">210</div>
    
    <div data-lotno="211" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">211</div>
    <div data-lotno="212" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">212</div>
    <div data-lotno="213" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">213</div>
    <div data-lotno="214" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">214</div>
    <div data-lotno="215" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">215</div>
    <div data-lotno="216" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">216</div>
    <div data-lotno="217" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">217</div>
    <div data-lotno="218" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">218</div>
    <div data-lotno="219" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">219</div>
    <div data-lotno="220" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">220</div>
    
    <div data-lotno="221" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">221</div>
    <div data-lotno="222" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">222</div>
    <div data-lotno="223" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">223</div>
    <div data-lotno="224" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">224</div>
    <div data-lotno="225" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">225</div>
    <div data-lotno="226" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">226</div>
    <div data-lotno="227" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">227</div>
    <div data-lotno="228" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">228</div>
    <div data-lotno="229" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">229</div>
    <div data-lotno="230" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">230</div>
    
    <div data-lotno="231" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">231</div>
    <div data-lotno="232" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">232</div>
    <div data-lotno="233" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">233</div>
    <div data-lotno="234" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">234</div>
    <div data-lotno="235" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">235</div>
    <div data-lotno="236" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">236</div>
    <div data-lotno="237" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">237</div>
    <div data-lotno="238" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">238</div>
    <div data-lotno="239" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">239</div>
    <div data-lotno="240" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">240</div>
    
    <div data-lotno="241" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">241</div>
    <div data-lotno="242" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">242</div>
    <div data-lotno="243" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">243</div>
    <div data-lotno="244" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">244</div>
    <div data-lotno="245" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">245</div>
    <div data-lotno="246" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">246</div>
    <div data-lotno="247" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">247</div>
    <div data-lotno="248" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">248</div>
    <div data-lotno="249" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">249</div>
    <div data-lotno="250" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">250</div>
    
    <div data-lotno="251" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">251</div>
    <div data-lotno="252" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">252</div>
    <div data-lotno="253" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">253</div>
    <div data-lotno="254" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">254</div>
    <div data-lotno="255" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">255</div>
    <div data-lotno="256" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">256</div>
    <div data-lotno="257" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">257</div>
    <div data-lotno="258" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">258</div>
    <div data-lotno="259" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">259</div>
    <div data-lotno="260" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">260</div>
    
    <div data-lotno="261" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">261</div>
    <div data-lotno="262" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">262</div>
    <div data-lotno="263" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">263</div>
    <div data-lotno="264" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">264</div>
    <div data-lotno="265" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">265</div>
    <div data-lotno="266" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">266</div>
    <div data-lotno="267" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">267</div>
    <div data-lotno="268" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">268</div>
    <div data-lotno="269" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">269</div>
    <div data-lotno="270" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">270</div>
    
    <div data-lotno="271" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">271</div>
    <div data-lotno="272" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">272</div>
    <div data-lotno="273" data-memsts="St. James" data-memlot="Lawn Lots" class="grid-itemjames">273</div>
    
                </div>
        </div>
          
        <area shape="rect" coords="2553,201,2605,905" href="#" title="St. Matthew">
          <div class="Matthew" id="Matthew">
              St. Matthew
            </div>
            <div class="stMatthew" id="idmatthew"><h3 style="color: white;">St. Matthew</h3><br>
                <button id="IDmatthewclosebtn" class="matthewclosebtn">&times;</button>
                <div class="medium" id="legendBox" style="top: 500px;">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                  <div class="matthewgrid" id="matthewgrid">
                <div data-lotno="1" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">1</div>
                <div data-lotno="2" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">2</div>
                <div data-lotno="3" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">3</div>
                <div data-lotno="4" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">4</div>
                <div data-lotno="5" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">5</div>
                <div data-lotno="6" data-memsts="St. Matthew" data-memlot="Garden Lots" class="grid-itemmatthew">6</div>
                </div>
                </div>
          <area shape="poly" coords="3285,1927,4095,2192,3735,3042,3123,2772,3186,2660,3258,2507,3294,2336,3303,2134" href="#" title="St. Agustine">
          <div class="Agustine" id="Agustine">
              St. Augustin
            </div>

            <div class="stAgustine" id="idagustine"><h3 style="color: white;">St. Augustin</h3><br>
                <button id="IDagustineclosebtn" class="agustineclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>

                <div class="agustinegrid" id="agustinegrid">
                <div data-lotno="1" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">1</div>
                <div data-lotno="2" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">2</div>
                <div data-lotno="3" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">3</div>
                <div data-lotno="4" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">4</div>
                <div data-lotno="5" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">5</div>
                <div data-lotno="6" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">6</div>
                <div data-lotno="7" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">7</div>
                <div data-lotno="8" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">8</div>
                <div data-lotno="9" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">9</div>
                <div data-lotno="10" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">10</div>
        
                <div data-lotno="11" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">11</div>
                <div data-lotno="12" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">12</div>
                <div data-lotno="13" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">13</div>
                <div data-lotno="14" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">14</div>
                <div data-lotno="15" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">15</div>
                <div data-lotno="16" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">16</div>
                <div data-lotno="17" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">17</div>
                <div data-lotno="18" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">18</div>
                <div data-lotno="19" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">19</div>
                <div data-lotno="20" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">20</div>
        
                <div data-lotno="21" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">21</div>
                <div data-lotno="22" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">22</div>
                <div data-lotno="23" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">23</div>
                <div data-lotno="24" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">24</div>
                <div data-lotno="25" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">25</div>
                <div data-lotno="26" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">26</div>
                <div data-lotno="27" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">27</div>
                <div data-lotno="28" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">28</div>
                <div data-lotno="29" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">29</div>
                <div data-lotno="30" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">30</div>
        
           
                <div data-lotno="31" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">31</div>
                <div data-lotno="32" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">32</div>
                <div data-lotno="33" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">33</div>
                <div data-lotno="34" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">34</div>
                <div data-lotno="35" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">35</div>
                <div data-lotno="36" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">36</div>
                <div data-lotno="37" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">37</div>
                <div data-lotno="38" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">38</div>
                <div data-lotno="39" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">39</div>
                <div data-lotno="40" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">40</div>
    
                <div data-lotno="41" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">41</div>
                <div data-lotno="42" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">42</div>
                <div data-lotno="43" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">43</div>
                <div data-lotno="44" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">44</div>
                <div data-lotno="45" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">45</div>
                <div data-lotno="46" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">46</div>
                <div data-lotno="47" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">47</div>
                <div data-lotno="48" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">48</div>
                <div data-lotno="49" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">49</div>
                <div data-lotno="50" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">50</div>
    
                <div data-lotno="51" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">51</div>
                <div data-lotno="52" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">52</div>
                <div data-lotno="53" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">53</div>
                <div data-lotno="54" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">54</div>
                <div data-lotno="55" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">55</div>
                <div data-lotno="56" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">56</div>
                <div data-lotno="57" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">57</div>
                <div data-lotno="58" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">58</div>
                <div data-lotno="59" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">59</div>
                <div data-lotno="60" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">60</div>

                <div data-lotno="61" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">61</div>
                <div data-lotno="62" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">62</div>
                <div data-lotno="63" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">63</div>
                <div data-lotno="64" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">64</div>
                <div data-lotno="65" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">65</div>
                <div data-lotno="66" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">66</div>
                <div data-lotno="67" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">67</div>
                <div data-lotno="68" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">68</div>
                <div data-lotno="69" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">69</div>
                <div data-lotno="70" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">70</div>
                
                <div data-lotno="71" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">71</div>
                <div data-lotno="72" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">72</div>
                <div data-lotno="73" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">73</div>
                <div data-lotno="74" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">74</div>
                <div data-lotno="75" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">75</div>
                <div data-lotno="76" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">76</div>
                <div data-lotno="77" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">77</div>
                <div data-lotno="78" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">78</div>
                <div data-lotno="79" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">79</div>
                <div data-lotno="80" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">80</div>

                <div data-lotno="81" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">81</div>
                <div data-lotno="82" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">82</div>
                <div data-lotno="83" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">83</div>
                <div data-lotno="84" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">84</div>
                <div data-lotno="85" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">85</div>
                <div data-lotno="86" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">86</div>
                <div data-lotno="87" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">87</div>
                <div data-lotno="88" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">88</div>
                <div data-lotno="89" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">89</div>
                <div data-lotno="90" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">90</div>

                <div data-lotno="91" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">91</div>
                <div data-lotno="92" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">92</div>
                <div data-lotno="93" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">93</div>
                <div data-lotno="94" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">94</div>
                <div data-lotno="95" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">95</div>
                <div data-lotno="96" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">96</div>
                <div data-lotno="97" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">97</div>
                <div data-lotno="98" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">98</div>
                <div data-lotno="99" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">99</div>
                <div data-lotno="100" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">100</div>

                <div data-lotno="101" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">101</div>
                <div data-lotno="102" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">102</div>
                <div data-lotno="103" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">103</div>
                <div data-lotno="104" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">104</div>
                <div data-lotno="105" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">105</div>
                <div data-lotno="106" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">106</div>
                <div data-lotno="107" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">107</div>
                <div data-lotno="108" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">108</div>
                <div data-lotno="109" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">109</div>
                <div data-lotno="110" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">110</div>

                <div data-lotno="111" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">111</div>
                <div data-lotno="112" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">112</div>
                <div data-lotno="113" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">113</div>
                <div data-lotno="114" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">114</div>
                <div data-lotno="115" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">115</div>
                <div data-lotno="116" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">116</div>
                <div data-lotno="117" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">117</div>
                <div data-lotno="118" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">118</div>
                <div data-lotno="119" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">119</div>
                <div data-lotno="120" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">120</div>

                <div data-lotno="121" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">121</div>
                <div data-lotno="122" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">122</div>
                <div data-lotno="123" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">123</div>
                <div data-lotno="124" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">124</div>
                <div data-lotno="125" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">125</div>
                <div data-lotno="126" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">126</div>
                <div data-lotno="127" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">127</div>
                <div data-lotno="128" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">128</div>
                <div data-lotno="129" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">129</div>
                <div data-lotno="130" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">130</div>

                <div data-lotno="131" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">131</div>
                <div data-lotno="132" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">132</div>
                <div data-lotno="133" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">133</div>
                <div data-lotno="134" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">134</div>
                <div data-lotno="135" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">135</div>
                <div data-lotno="136" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">136</div>
                <div data-lotno="137" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">137</div>
                <div data-lotno="138" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">138</div>
                <div data-lotno="139" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">139</div>
                <div data-lotno="140" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">140</div>

                <div data-lotno="141" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">141</div>
                <div data-lotno="142" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">142</div>
                <div data-lotno="143" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">143</div>
                <div data-lotno="144" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">144</div>
                <div data-lotno="145" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">145</div>
                <div data-lotno="146" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">146</div>
                <div data-lotno="147" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">147</div>
                <div data-lotno="148" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">148</div>
                <div data-lotno="149" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">149</div>
                <div data-lotno="150" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">150</div>

                <div data-lotno="151" data-memsts="St. Augustin" data-memlot="Lawn Lots" class="grid-itemagustine">151</div>
              
                </div>
            </div>
          <area shape="poly" coords="4109,761,4703,766,4127,2111,3654,1990" href="#" title="St. Dominic">
          <div class="Dominic" id="Dominic">
              St. Dominic
            </div>
            <div class="stDominic" id="iddominic"><h3 style="color: white;">St. Dominic</h3><br>
                <button id="IDdominicclosebtn" class="dominicclosebtn">&times;</button>
                <div class="Saints" id="legendBox" >
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="dominicgrid" id="dominicgrid">
    <div data-lotno="1" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">1</div>
    <div data-lotno="2" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">2</div>
    <div data-lotno="3" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">3</div>
    <div data-lotno="4" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">4</div>
    <div data-lotno="5" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">5</div>
    <div data-lotno="6" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">6</div>
    <div data-lotno="7" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">7</div>
    <div data-lotno="8" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">8</div>
    <div data-lotno="9" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">9</div>
    <div data-lotno="10" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">10</div>
    
    <div data-lotno="11" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">11</div>
    <div data-lotno="12" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">12</div>
    <div data-lotno="13" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">13</div>
    <div data-lotno="14" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">14</div>
    <div data-lotno="15" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">15</div>
    <div data-lotno="16" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">16</div>
    <div data-lotno="17" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">17</div>
    <div data-lotno="18" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">18</div>
    <div data-lotno="19" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">19</div>
    <div data-lotno="20" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">20</div>
    
    <div data-lotno="21" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">21</div>
    <div data-lotno="22" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">22</div>
    <div data-lotno="23" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">23</div>
    <div data-lotno="24" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">24</div>
    <div data-lotno="25" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">25</div>
    <div data-lotno="26" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">26</div>
    <div data-lotno="27" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">27</div>
    <div data-lotno="28" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">28</div>
    <div data-lotno="29" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">29</div>
    <div data-lotno="30" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">30</div>
    
    <div data-lotno="31" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">31</div>
    <div data-lotno="32" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">32</div>
    <div data-lotno="33" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">33</div>
    <div data-lotno="34" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">34</div>
    <div data-lotno="35" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">35</div>
    <div data-lotno="36" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">36</div>
    <div data-lotno="37" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">37</div>
    <div data-lotno="38" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">38</div>
    <div data-lotno="39" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">39</div>
    <div data-lotno="40" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">40</div>
    
    <div data-lotno="41" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">41</div>
    <div data-lotno="42" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">42</div>
    <div data-lotno="43" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">43</div>
    <div data-lotno="44" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">44</div>
    <div data-lotno="45" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">45</div>
    <div data-lotno="46" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">46</div>
    <div data-lotno="47" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">47</div>
    <div data-lotno="48" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">48</div>
    <div data-lotno="49" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">49</div>
    <div data-lotno="50" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">50</div>
    
    <div data-lotno="51" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">51</div>
    <div data-lotno="52" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">52</div>
    <div data-lotno="53" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">53</div>
    <div data-lotno="54" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">54</div>
    <div data-lotno="55" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">55</div>
    <div data-lotno="56" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">56</div>
    <div data-lotno="57" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">57</div>
    <div data-lotno="58" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">58</div>
    <div data-lotno="59" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">59</div>
    <div data-lotno="60" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">60</div>
    
    <div data-lotno="61" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">61</div>
    <div data-lotno="62" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">62</div>
    <div data-lotno="63" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">63</div>
    <div data-lotno="64" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">64</div>
    <div data-lotno="65" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">65</div>
    <div data-lotno="66" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">66</div>
    <div data-lotno="67" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">67</div>
    <div data-lotno="68" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">68</div>
    <div data-lotno="69" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">69</div>
    <div data-lotno="70" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">70</div>
    
    <div data-lotno="71" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">71</div>
    <div data-lotno="72" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">72</div>
    <div data-lotno="73" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">73</div>
    <div data-lotno="74" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">74</div>
    <div data-lotno="75" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">75</div>
    <div data-lotno="76" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">76</div>
    <div data-lotno="77" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">77</div>
    <div data-lotno="78" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">78</div>
    <div data-lotno="79" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">79</div>
    <div data-lotno="80" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">80</div>
    
    <div data-lotno="81" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">81</div>
    <div data-lotno="82" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">82</div>
    <div data-lotno="83" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">83</div>
    <div data-lotno="84" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">84</div>
    <div data-lotno="85" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">85</div>
    <div data-lotno="86" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">86</div>
    <div data-lotno="87" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">87</div>
    <div data-lotno="88" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">88</div>
    <div data-lotno="89" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">89</div>
    <div data-lotno="90" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">90</div>
    
    <div data-lotno="91" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">91</div>
    <div data-lotno="92" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">92</div>
    <div data-lotno="93" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">93</div>
    <div data-lotno="94" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">94</div>
    <div data-lotno="95" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">95</div>
    <div data-lotno="96" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">96</div>
    <div data-lotno="97" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">97</div>
    <div data-lotno="98" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">98</div>
    <div data-lotno="99" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">99</div>
    <div data-lotno="100" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">100</div>
    
    <div data-lotno="101" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">101</div>
    <div data-lotno="102" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">102</div>
    <div data-lotno="103" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">103</div>
    <div data-lotno="104" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">104</div>
    <div data-lotno="105" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">105</div>
    <div data-lotno="106" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">106</div>
    <div data-lotno="107" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">107</div>
    <div data-lotno="108" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">108</div>
    <div data-lotno="109" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">109</div>
    <div data-lotno="110" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">110</div>
    
    <div data-lotno="111" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">111</div>
    <div data-lotno="112" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">112</div>
    <div data-lotno="113" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">113</div>
    <div data-lotno="114" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">114</div>
    <div data-lotno="115" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">115</div>
    <div data-lotno="116" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">116</div>
    <div data-lotno="117" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">117</div>
    <div data-lotno="118" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">118</div>
    <div data-lotno="119" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">119</div>
    <div data-lotno="120" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">120</div>
    
    <div data-lotno="121" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">121</div>
    <div data-lotno="122" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">122</div>
    <div data-lotno="123" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">123</div>
    <div data-lotno="124" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">124</div>
    <div data-lotno="125" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">125</div>
    <div data-lotno="126" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">126</div>
    <div data-lotno="127" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">127</div>
    <div data-lotno="128" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">128</div>
    <div data-lotno="129" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">129</div>
    <div data-lotno="130" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">130</div>
    
    <div data-lotno="131" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">131</div>
    <div data-lotno="132" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">132</div>
    <div data-lotno="133" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">133</div>
    <div data-lotno="134" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">134</div>
    <div data-lotno="135" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">135</div>
    <div data-lotno="136" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">136</div>
    <div data-lotno="137" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">137</div>
    <div data-lotno="138" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">138</div>
    <div data-lotno="139" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">139</div>
    <div data-lotno="140" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">140</div>
    
    <div data-lotno="141" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">141</div>
    <div data-lotno="142" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">142</div>
    <div data-lotno="143" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">143</div>
    <div data-lotno="144" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">144</div>
    <div data-lotno="145" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">145</div>
    <div data-lotno="146" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">146</div>
    <div data-lotno="147" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">147</div>
    <div data-lotno="148" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">148</div>
    <div data-lotno="149" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">149</div>
    <div data-lotno="150" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">150</div>
    
    <div data-lotno="151" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">151</div>
    <div data-lotno="152" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">152</div>
    <div data-lotno="153" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">153</div>
    <div data-lotno="154" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">154</div>
    <div data-lotno="155" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">155</div>
    <div data-lotno="156" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">156</div>
    <div data-lotno="157" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">157</div>
    <div data-lotno="158" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">158</div>
    <div data-lotno="159" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">159</div>
    <div data-lotno="160" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">160</div>
    
    <div data-lotno="161" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">161</div>
    <div data-lotno="162" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">162</div>
    <div data-lotno="163" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">163</div>
    <div data-lotno="164" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">164</div>
    <div data-lotno="165" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">165</div>
    <div data-lotno="166" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">166</div>
    <div data-lotno="167" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">167</div>
    <div data-lotno="168" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">168</div>
    <div data-lotno="169" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">169</div>
    <div data-lotno="170" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">170</div>
    
    <div data-lotno="171" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">171</div>
    <div data-lotno="172" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">172</div>
    <div data-lotno="173" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">173</div>
    <div data-lotno="174" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">174</div>
    <div data-lotno="175" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">175</div>
    <div data-lotno="176" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">176</div>
    <div data-lotno="177" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">177</div>
    <div data-lotno="178" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">178</div>
    <div data-lotno="179" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">179</div>
    <div data-lotno="180" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">180</div>
    
    <div data-lotno="181" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">181</div>
    <div data-lotno="182" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">182</div>
    <div data-lotno="183" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">183</div>
    <div data-lotno="184" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">184</div>
    <div data-lotno="185" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">185</div>
    <div data-lotno="186" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">186</div>
    <div data-lotno="187" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">187</div>
    <div data-lotno="188" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">188</div>
    <div data-lotno="189" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">189</div>
    <div data-lotno="190" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">190</div>
    
    <div data-lotno="191" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">191</div>
    <div data-lotno="192" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">192</div>
    <div data-lotno="193" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">193</div>
    <div data-lotno="194" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">194</div>
    <div data-lotno="195" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">195</div>
    <div data-lotno="196" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">196</div>
    <div data-lotno="197" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">197</div>
    <div data-lotno="198" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">198</div>
    <div data-lotno="199" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">199</div>
    <div data-lotno="200" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">200</div>
    
    <div data-lotno="201" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">201</div>
    <div data-lotno="202" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">202</div>
    <div data-lotno="203" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">203</div>
    <div data-lotno="204" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">204</div>
    <div data-lotno="205" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">205</div>
    <div data-lotno="206" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">206</div>
    <div data-lotno="207" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">207</div>
    <div data-lotno="208" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">208</div>
    <div data-lotno="209" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">209</div>
    <div data-lotno="210" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">210</div>
    
    <div data-lotno="211" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">211</div>
    <div data-lotno="212" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">212</div>
    <div data-lotno="213" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">213</div>
    <div data-lotno="214" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">214</div>
    <div data-lotno="215" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">215</div>
    <div data-lotno="216" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">216</div>
    <div data-lotno="217" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">217</div>
    <div data-lotno="218" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">218</div>
    <div data-lotno="219" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">219</div>
    <div data-lotno="220" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">220</div>
    
    <div data-lotno="221" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">221</div>
    <div data-lotno="222" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">222</div>
    <div data-lotno="223" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">223</div>
    <div data-lotno="224" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">224</div>
    <div data-lotno="225" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">225</div>
    <div data-lotno="226" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">226</div>
    <div data-lotno="227" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">227</div>
    <div data-lotno="228" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">228</div>
    <div data-lotno="229" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">229</div>
    <div data-lotno="230" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">230</div>
    
    <div data-lotno="231" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">231</div>
    <div data-lotno="232" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">232</div>
    <div data-lotno="233" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">233</div>
    <div data-lotno="234" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">234</div>
    <div data-lotno="235" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">235</div>
    <div data-lotno="236" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">236</div>
    <div data-lotno="237" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">237</div>
    <div data-lotno="238" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">238</div>
    <div data-lotno="239" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">239</div>
    <div data-lotno="240" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">240</div>
    
    <div data-lotno="241" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">241</div>
    <div data-lotno="242" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">242</div>
    <div data-lotno="243" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">243</div>
    <div data-lotno="244" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">244</div>
    <div data-lotno="245" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">245</div>
    <div data-lotno="246" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">246</div>
    <div data-lotno="247" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">247</div>
    <div data-lotno="248" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">248</div>
    <div data-lotno="249" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">249</div>
    <div data-lotno="250" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">250</div>
    
    <div data-lotno="251" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">251</div>
    <div data-lotno="252" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">252</div>
    <div data-lotno="253" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">253</div>
    <div data-lotno="254" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">254</div>
    <div data-lotno="255" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">255</div>
    <div data-lotno="256" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">256</div>
    <div data-lotno="257" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">257</div>
    <div data-lotno="258" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">258</div>
    <div data-lotno="259" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">259</div>
    <div data-lotno="260" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">260</div>
    
    <div data-lotno="261" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">261</div>
    <div data-lotno="262" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">262</div>
    <div data-lotno="263" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">263</div>
    <div data-lotno="264" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">264</div>
    <div data-lotno="265" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">265</div>
    <div data-lotno="266" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">266</div>
    <div data-lotno="267" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">267</div>
    <div data-lotno="268" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">268</div>
    <div data-lotno="269" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">269</div>
    <div data-lotno="270" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">270</div>
    
    <div data-lotno="271" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">271</div>
    <div data-lotno="272" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">272</div>
    <div data-lotno="273" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">273</div>
    <div data-lotno="274" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">274</div>
    <div data-lotno="275" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">275</div>
    <div data-lotno="276" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">276</div>
    <div data-lotno="277" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">277</div>
    <div data-lotno="278" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">278</div>
    <div data-lotno="279" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">279</div>
    <div data-lotno="280" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">280</div>
    
    <div data-lotno="281" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">281</div>
    <div data-lotno="282" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">282</div>
    <div data-lotno="283" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">283</div>
    <div data-lotno="284" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">284</div>
    <div data-lotno="285" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">285</div>
    <div data-lotno="286" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">286</div>
    <div data-lotno="287" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">287</div>
    <div data-lotno="288" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">288</div>
    <div data-lotno="289" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">289</div>
    <div data-lotno="290" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">290</div>
    
    <div data-lotno="291" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">291</div>
    <div data-lotno="292" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">292</div>
    <div data-lotno="293" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">293</div>
    <div data-lotno="294" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">294</div>
    <div data-lotno="295" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">295</div>
    <div data-lotno="296" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">296</div>
    <div data-lotno="297" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">297</div>
    <div data-lotno="298" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">298</div>
    <div data-lotno="299" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">299</div>
    <div data-lotno="300" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">300</div>
    
    <div data-lotno="301" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">301</div>
    <div data-lotno="302" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">302</div>
    <div data-lotno="303" data-memsts="St. Dominic" data-memlot="Lawn Lots" class="grid-itemdominic">303</div>
    
                    </div>
            </div>
          <area shape="rect" coords="2549,21,3465,733" href="#" title="St. Mark">
          <div class="Mark" id="Mark">
            St. Mark
          </div>
          <div class="stMark" id="idmark"><h3 style="color: white;">St. Mark</h3><br>
            <button id="IDmarkclosebtn" class="markclosebtn">&times;</button>
            <div class="medium" id="legendBox" style="top: 480px;">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
            <div class="markgrid" id="markgrid">
            <div data-lotno="1" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">1</div>
            <div data-lotno="2" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">2</div>
            <div data-lotno="3" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">3</div>
            <div data-lotno="4" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">4</div>
            <div data-lotno="5" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">5</div>
            <div data-lotno="6" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">6</div>
            <div data-lotno="7" data-memsts="St. Mark" data-memlot="Family Estate" class="grid-itemmark">7</div>
            
            </div>
            </div>
          <area shape="rect" coords="3541,21,5089,101" href="#" title="St. Luke">
          <div class="Luke" id="Luke">
            St. Lukes
          </div>
          <div class="stLuke" id="idluke"><h3 style="color: white;">St. Lukes</h3><br>
            <button id="IDlukeclosebtn" class="lukeclosebtn">&times;</button>
            <div class="medium" id="legendBox" style="top: 500px;">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
            <div class="lukegrid" id="lukegrid">
            <div data-lotno="1" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">1</div>
            <div data-lotno="2" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">2</div>
            <div data-lotno="3" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">3</div>
            <div data-lotno="4" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">4</div>
            <div data-lotno="5" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">5</div>
            <div data-lotno="6" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">6</div>
            <div data-lotno="7" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">7</div>
            <div data-lotno="8" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">8</div>
            <div data-lotno="9" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">9</div>
            <div data-lotno="10" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">10</div>
            <div data-lotno="11" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">11</div>
            <div data-lotno="12" data-memsts="St. Lukes" data-memlot="Family Estate" class="grid-itemluke">12</div>
            
            </div>
            </div>
            <area shape="poly" coords="4743,761,4807,761,3825,3083,3776,3069" href="#" title="St. Isidore">
            <div class="Isidore" id="Isidore">
              St. Isidore
            </div>
            <div class="stIsidore" id="idisidore"><h3 style="color: white;">St. Isidore</h3><br>
                <button id="IDisidoreclosebtn" class="isidoreclosebtn">&times;</button>
                <div class="narrow" id="legendBox" style="top: 550px;">
                        <div class="legends">Legend</div>
                        <div class="legendList">
                        <div class="legendU Available"></div>
                        <span>Available lots</span>
                        </div>
                    <div class="legendList">
                      <div class="legendU Unavailable"></div>
                      <span>Owned lots</span>
                    </div>
                  </div>
                <div class="isidoregrid" id="isidoregrid">
                <div data-lotno="1" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">1</div>
                <div data-lotno="2" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">2</div>
                <div data-lotno="3" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">3</div>
                <div data-lotno="4" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">4</div>
                <div data-lotno="5" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">5</div>
                <div data-lotno="6" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">6</div>
                <div data-lotno="7" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">7</div>
                <div data-lotno="8" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">8</div>
                <div data-lotno="9" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">9</div>
                <div data-lotno="10" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">10</div>

                <div data-lotno="11" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">11</div>
                <div data-lotno="12" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">12</div>
                <div data-lotno="13" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">13</div>
                <div data-lotno="14" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">14</div>
                <div data-lotno="15" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">15</div>
                <div data-lotno="16" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">16</div>
                <div data-lotno="17" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">17</div>
                <div data-lotno="18" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">18</div>
                <div data-lotno="19" data-memsts="St. Isidore" data-memlot="Garden Lots" class="grid-itemisidore">19</div>

                
                </div>
                </div>
                <div class="Michael" id="Michael">
                    St. Michael <br> and <br> St. Patrick 
                  </div>
                  <div class="stpm" id="idpm"><h3 style="color: white;">St. Michael and St. Patrick</h3><br>
                    <button id="IDpmclosebtn" class="pmclosebtn">&times;</button>
                    <div class="medium" id="legendBox" style="top: 500px;">
                            <div class="legends">Legend</div>
                            <div class="legendList">
                            <div class="legendU Available"></div>
                            <span>Available lots</span>
                            </div>
                        <div class="legendList">
                          <div class="legendU Unavailable"></div>
                          <span>Owned lots</span>
                        </div>
                      </div>
                      <div class="pmgrid" id="pmgrid">
                    <div data-lotno="1" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">1</div>
                    <div data-lotno="2" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">2</div>
                    <div data-lotno="3" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">3</div>
                    <div data-lotno="4" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">4</div>
                    <div data-lotno="5" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">5</div>
                    <div data-lotno="6" data-memsts="St. Michael" data-memlot="Garden Lots" class="grid-itempm">6</div>
                    <div data-lotno="1" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">1</div>
                    <div data-lotno="2" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">2</div>
                    <div data-lotno="3" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">3</div>
                    <div data-lotno="4" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">4</div>
                    <div data-lotno="5" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">5</div>
                    <div data-lotno="6" data-memsts="St. Patrick" data-memlot="Garden Lots" class="grid-itempm">6</div>
                    </div>
                    </div>
            
      </map>
       
    </div>
    
    <?php include 'staff_sidebar.php'; ?>
    
     <div class="LotOverview" id="overview">
        <div class="Content">
          <p class="overview-title">Lot Overview</p>
          <div class="lotdetails">
            <h4 style="font-weight: bold;">I. FAMILY ESTATE</h4>
                <p style="font-size: 15px;">St. Lukes - 11 Lots</p>
                <p style="font-size: 15px;">St. Mark -  7 Lots</p>
                <p style="font-size: 15px;">St. Michael - 6 Lots</p>
                <p style="font-size: 15px;">St. Patrick - 6 Lots</p>
                <hr>
                <p style="font-size: 15px; font-weight: bold;" >SUB TOTAL - 30 Lots</p><br>
                <h4 style="font-weight: bold;">II. GARDEN ESTATE</h4>
                <p style="font-size: 15px;">St. Isidore - 19 Lots</p>
                <p style="font-size: 15px;">St. Matthew -  8 Lots</p>
                <hr>
                <p style="font-size: 15px; font-weight: bold;">SUB TOTAL - 27 Lots</p><br>
                <h4 style="font-weight: bold;">II. LAWN LOTS</h4>
                <p style="font-size: 15px;">St. Jude - 186 Lots</p>
                <p style="font-size: 15px;">St. John -  135 Lots</p>
                <p style="font-size: 15px;">St. Joseph - 173 Lots</p>
                <p style="font-size: 15px;">St. James -  273 Lots</p>
                <p style="font-size: 15px;">St. Dominic - 304 Lots</p>
                <p style="font-size: 15px;">St. Augustin -  149 Lots</p>
                <p style="font-size: 15px;">St. Rafael - 58 Lots</p>
                <p style="font-size: 15px;">St. Peter -  71 Lots</p>
                <p style="font-size: 15px;">St. Paul -  71 Lots</p>
                <hr>
                <p  style="font-size: 15px; font-weight: bold;">SUB TOTAL - 1420 Lots</p>
     
          </div>
        </div>
      </div>
      <!-- logout confirmation modal -->
<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Logout Confirmation</h2>
        <p>Are you sure you want to logout?</p>
        <div class="modal-buttons">
            <button id="confirmButton" class="btn btn-confirm">Yes, log me out</button>
            <button id="cancelButton" class="btn btn-cancel">No, Stay here</button>
        </div>
    </div>
</div>
    <script src="paiyakan.js"></script>
    <script src="LotInfo.js"></script>
    <script src="script.js"></script>
    <script>
        

        
        //try for responsive imagemap
window.onload = function() {
            var img = document.getElementById('responsiveImage');
            var map = document.getElementById('mymap');
            var originalWidth = img.naturalWidth;

            function adjustCoords() {
                var currentWidth = img.clientWidth;
                var scale = currentWidth / originalWidth;

                Array.from(map.areas).forEach(function(area) {
                    var coords = area.coords.split(',').map(function(coord) {
                        return Math.round(coord * scale);
                    });
                    area.coords = coords.join(',');
                });
            }

            adjustCoords();
            window.onresize = adjustCoords;
        };
        
document.addEventListener('DOMContentLoaded', function() {
    
      var C1 = document.getElementById('C1');
      var C11stflr = document.getElementById('C11stflr');
      var C12ndflr = document.getElementById('C12ndflr');
      var C1trigger = document.getElementById('Colum1');
      var C1closeButton = document.getElementById('C1closePopup');

      var C2 = document.getElementById('C2');
      var C21stflr = document.getElementById('C21stflr');
      var C22ndflr = document.getElementById('C22ndflr');
      var C2trigger = document.getElementById('Colum2');
      var C2closeButton = document.getElementById('C2closePopup');

      var C11st = document.getElementById('C11st');
      var C11stflrSA = document.getElementById('C11stflrSA');
      var C11stflrSB = document.getElementById('C11stflrSB');
      var C11stflr = document.getElementById('C11stflr');
      var C1closePopup1st = document.getElementById('C1closePopup1st');

      var C12ndS = document.getElementById('C12ndS');
      var C12ndflrSSA = document.getElementById('C12ndflrSSA');
      var C12ndlrSSB = document.getElementById('C12ndflrSSB');
      var C12ndflrSA = document.getElementById('C12ndflrSA');
      var C1closePopupS = document.getElementById('C1closePopupS');
      
      var C11stS1 = document.getElementById('C11stS1');
      var C11stflrSSA = document.getElementById('C11stflrSSA');
      var C11stflrSSB = document.getElementById('C11stflrSSB');
      var C11stflrblk3 = document.getElementById('C11stflrblk3');
      var C11stclosePopupS = document.getElementById('C11stclosePopupS');
//BLK
      var C11stblk3 = document.getElementById('C11stblk3');
      var C11stflrblk3A = document.getElementById('C11stflrblk3A');
      var C11stflrblk3B = document.getElementById('C11stflrblk3B');
      var C11stflrblk3 = document.getElementById('C11stflrblk3');
      var C11stclosePopupblk3 = document.getElementById('C11stclosePopupblk3');

      var C11stblk4 = document.getElementById('C11stblk4');
      var C11stflrblk4A = document.getElementById('C11stflrblk4A');
      var C11stflrblk4B = document.getElementById('C11stflrblk4B');
      var C11stflrblk4 = document.getElementById('C11stflrblk4');
      var C11stclosePopupblk4 = document.getElementById('C11stclosePopupblk4');

      var C22ndflrblk3 = document.getElementById('C22ndflrblk3');
      var C22blk3A = document.getElementById('C22blk3A');
      var C22blk3B = document.getElementById('C22blk3B');
      var C22ndflrblck3 = document.getElementById('C22ndflrblck3');
      var C22blk3closePopup = document.getElementById('C22blk3closePopup');
      
      var C22ndflrblk4 = document.getElementById('C22ndflrblk4');
      var C22blk4A = document.getElementById('C22blk4A');
      var C22blk4B = document.getElementById('C22blk4B');
      var C22ndflrblck4 = document.getElementById('C22ndflrblck4');
      var C22blk4closePopup = document.getElementById('C22blk4closePopup');

      var C21stflrblk3 = document.getElementById('C21stflrblk3');
      var C2S2blk3A = document.getElementById('C2S2blk3A');
      var C2S2blk3B = document.getElementById('C2S2blk3B');
      var C21stflrblck3 = document.getElementById('C21stflrblck3');
      var C2S2closePopupblk3 = document.getElementById('C2S2closePopupblk3');

      var C21stflrblk4 = document.getElementById('C21stflrblk4');
      var C2S2blk4A = document.getElementById('C2S2blk4A');
      var C2S2blk4B = document.getElementById('C2S2blk4B');
      var C21stflrblck4 = document.getElementById('C21stflrblck4');
      var C2S2closePopupblk4 = document.getElementById('C2S2closePopupblk4');

      var C12ndblk3 = document.getElementById('C12ndblk3');
      var C12ndflrblk3A = document.getElementById('C12ndflrblk3A');
      var C12ndflrblk3B = document.getElementById('C12ndflrblk3B');
      var C12ndflrblck3 = document.getElementById('C12ndflrblck3');
      var C12ndclosePopupblk3 = document.getElementById('C12ndclosePopupblk3');
      
      var C12ndblk4 = document.getElementById('C12ndblk4');
      var C12ndflrblk4A = document.getElementById('C12ndflrblk4A');
      var C12ndflrblk4B = document.getElementById('C12ndflrblk4B');
      var C12ndflrblck4 = document.getElementById('C12ndflrblck4');
      var C12ndclosePopupblk4 = document.getElementById('C12ndclosePopupblk4');

//BLK
      var C21stflrS1 = document.getElementById('C21stflrS1');
      var C2S1SA = document.getElementById('C2S1SA');
      var C2S1SB = document.getElementById('C2S1SB');
      var C21stflrSA = document.getElementById('C21stflrSA');
      var C2S1closePopup = document.getElementById('C2S1closePopup');

      var C21stflrS2 = document.getElementById('C21stflrS2');
      var C2S2SA = document.getElementById('C2S2SA');
      var C2S2SB = document.getElementById('C2S2SB');
      var C21stflrSB = document.getElementById('C21stflrSB');
      var C2S2closePopup = document.getElementById('C2S2closePopup');
      

      var C12ndS2 = document.getElementById('C12ndS2');
      var C12ndS2flrSSA = document.getElementById('C12ndS2flrSSA');
      var C12ndS2flrSSB = document.getElementById('C12ndS2flrSSB');
      var C12ndflrSB = document.getElementById('C12ndflrSB');
      var C12ndclosebuttonS2 = document.getElementById('C12ndclosePopupS2');

      var C12nd = document.getElementById('C12nd');
      var C12ndflrSA = document.getElementById('C12ndflrSA');
      var C12ndflrSB = document.getElementById('C12ndflrSB');
      var C12ndflr = document.getElementById('C12ndflr');
      var C1closebuttonS = document.getElementById('C1closebuttonS');

      var C21st = document.getElementById('C21st');
      var C21stflrSA = document.getElementById('C21stflrSA');
      var C21stflrSB = document.getElementById('C21stflrSB');
      var C21stflr = document.getElementById('C21stflr');
      var C2closePopup1st = document.getElementById('C2closePopup1st');

      var C22nd = document.getElementById('C22nd');
      var C22ndflrSA = document.getElementById('C22ndflrSA');
      var C22ndflrSB = document.getElementById('C22ndflrSB');
      var C22ndflr = document.getElementById('C22ndflr');
      var C2closePopup2nd = document.getElementById('C2closePopup2nd');

      var C11stS2 = document.getElementById('C11stS2');
      var C11stflrS2SA = document.getElementById('C11stflrS2SA');
      var C11stflrS2SB = document.getElementById('C11stflrS2SB');
      var C11stflrSB = document.getElementById('C11stflrSB');
      var C11stclosePopupS2 = document.getElementById('C11stclosePopupS2');

      var C22ndflrS1 = document.getElementById('C22ndflrS1');
      var C22SA = document.getElementById('C22SA');
      var C22SB = document.getElementById('C22SB');
      var C12ndflrSA = document.getElementById('C12ndflrSA');
      var C22S1closePopup = document.getElementById('C22S1closePopup');

      var C22ndflrS2 = document.getElementById('C22ndflrS2');
      var C22SA2 = document.getElementById('C22SA2');
      var C22SB2 = document.getElementById('C22SB2');
      var C22ndflrSB = document.getElementById('C22ndflrSB');
      var C22S2closePopup = document.getElementById('C22S2closePopup');
      



      var A1 = document.getElementById('A1');
      var A1sideA = document.getElementById('A1sideA');
      var A1sideB = document.getElementById('A1sideB');
      var A1trigger = document.getElementById('Apart1');
      var A1closeButton = document.getElementById('A1closePopup');
      


      var A2 = document.getElementById('A2');
      var A2sideA = document.getElementById('A2sideA');
      var A2sideB = document.getElementById('A2sideB');
      var A2trigger = document.getElementById('Apart2');
      var A2closeButton = document.getElementById('A2closePopup');
      
      var A3 = document.getElementById('A3');
      var A3sideA = document.getElementById('A3sideA');
      var A3sideB = document.getElementById('A3sideB');
      var A3trigger = document.getElementById('Apart3');
      var A3closeButton = document.getElementById('A3closePopup');
      
      var image = document.getElementById('responsiveImage');
      var bg = document.getElementById('bg');

    

      
      var idRAF = document.getElementById('idRAF');
      var Rafaelbtn = document.getElementById('Rafael');
      var IDRAFaclosebtn = document.getElementById('IDRAFaclosebtn');
      
      var idpeter = document.getElementById('idpeter');
      var Peterbtn = document.getElementById('Peter');
      var IDpeterclosebtn = document.getElementById('IDpeterclosebtn');

      var idpaul = document.getElementById('idpaul');
      var Paulbtn = document.getElementById('Paul');
      var IDpaulclosebtn = document.getElementById('IDpaulclosebtn');

      var idagustine = document.getElementById('idagustine');
      var Agustinebtn = document.getElementById('Agustine');
      var IDagustineclosebtn = document.getElementById('IDagustineclosebtn');
    
      var idjames = document.getElementById('idjames');
      var jamesbtn = document.getElementById('James');
      var IDjamesclosebtn = document.getElementById('IDjamesclosebtn');

      var idjoseph = document.getElementById('idjoseph');
      var josephbtn = document.getElementById('Joseph');
      var IDjosephclosebtn = document.getElementById('IDjosephclosebtn');

      var idjohn = document.getElementById('idjohn');
      var johnbtn = document.getElementById('John');
      var IDjohnclosebtn = document.getElementById('IDjohnclosebtn');

      var idjude = document.getElementById('idjude');
      var judebtn = document.getElementById('Jude');
      var IDjudeclosebtn = document.getElementById('IDjudeclosebtn');

      var idmatthew = document.getElementById('idmatthew');
      var Matthewbtn = document.getElementById('Matthew');
      var IDmatthewclosebtn = document.getElementById('IDmatthewclosebtn');

      var idpm = document.getElementById('idpm');
      var pmbtn = document.getElementById('Michael');
      var IDpmclosebtn = document.getElementById('IDpmclosebtn');

      var idisidore = document.getElementById('idisidore');
      var isidorebtn = document.getElementById('Isidore');
      var IDisidoreclosebtn = document.getElementById('IDisidoreclosebtn');

      var iddominic = document.getElementById('iddominic');
      var dominicbtn = document.getElementById('Dominic');
      var IDdominicclosebtn = document.getElementById('IDdominicclosebtn');

      var idmark = document.getElementById('idmark');
      var markbtn = document.getElementById('Mark');
      var IDmarkclosebtn = document.getElementById('IDmarkclosebtn');
      
      var idluke = document.getElementById('idluke');
      var lukebtn = document.getElementById('Luke');
      var IDlukeclosebtn = document.getElementById('IDlukeclosebtn');


      
     
  
      function openPopup(popup, sideA, sideB) {
    popup.style.display = 'block';  
    sideA.style.display = 'block';
    sideB.style.display = 'block';
    setTimeout(function() {
        popup.classList.add('open'); 
    }, 10);  

    image.classList.add('blur'); 
}

function closePopup(popup) {
    popup.classList.remove('open'); 
    popup.classList.add('close');    

    
    setTimeout(function() {
        popup.style.display = 'none'; 
        popup.classList.remove('close');
    }, 600);  
    
    image.classList.remove('blur');
}
    image.addEventListener('click', function(event) {
    event.stopPropagation();
});
    bg.addEventListener('click', function(event) {
    event.stopPropagation(); 
});




    //SAINTS


    lukebtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idluke);
    });
    IDlukeclosebtn.addEventListener('click', function() {
        closePopup(idluke);
    });
    markbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idmark);
    });
    IDmarkclosebtn.addEventListener('click', function() {
        closePopup(idmark);
    });
    dominicbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(iddominic);
    });
    IDdominicclosebtn.addEventListener('click', function() {
        closePopup(iddominic);
    });

    isidorebtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idisidore);
    });
    IDisidoreclosebtn.addEventListener('click', function() {
        closePopup(idisidore);
    });

    //
    
    pmbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idpm);
    });
    IDpmclosebtn.addEventListener('click', function() {
        closePopup(idpm);
    });

    Matthewbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idmatthew);
    });
    IDmatthewclosebtn.addEventListener('click', function() {
        closePopup(idmatthew);
    });

    judebtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idjude);
    });
    IDjudeclosebtn.addEventListener('click', function() {
        closePopup(idjude);
    });
    
    johnbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idjohn);
    });
    IDjohnclosebtn.addEventListener('click', function() {
        closePopup(idjohn);
    });
    josephbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idjoseph);
    });
    IDjosephclosebtn.addEventListener('click', function() {
        closePopup(idjoseph);
    });

    jamesbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idjames);
    });
    IDjamesclosebtn.addEventListener('click', function() {
        closePopup(idjames);
    });


    Agustinebtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idagustine);
    });
    IDagustineclosebtn.addEventListener('click', function() {
        closePopup(idagustine);
    });

    Paulbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idpaul);
    });
    IDpaulclosebtn.addEventListener('click', function() {
        closePopup(idpaul);
    });

    Peterbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idpeter);
    });
    IDpeterclosebtn.addEventListener('click', function() {
        closePopup(idpeter);
    });

    Rafaelbtn.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(idRAF);
    });
    IDRAFaclosebtn.addEventListener('click', function() {
        closePopup(idRAF);
    });
//APART/COLUM
    C22ndflrSB.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C22ndflrS2, C22SA2, C22SB2);
    });
    C22ndflrSA.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C22ndflrS1, C22SA, C22SB);
    });

    C21stflrSB.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C21stflrS2, C2S2SA, C2S2SB);
    });
   
    C21stflrSA.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C21stflrS1, C2S1SA, C2S1SB);
    });
    C11stflrSB.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C11stS2, C11stflrS2SA, C11stflrS2SB);
    });
    //BLK
    C11stflrblk3.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C11stblk3, C11stflrblk3A, C11stflrblk3B);
    });
    C11stclosePopupblk3.addEventListener('click', function() {
        closePopup(C11stblk3);
    });

    C11stflrblk4.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C11stblk4, C11stflrblk4A, C11stflrblk4B);
    });
    C11stclosePopupblk4.addEventListener('click', function() {
        closePopup(C11stblk4);
    });

    C22ndflrblck3.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C22ndflrblk3, C22blk3A, C22blk3B);
    });
    C22blk3closePopup.addEventListener('click', function() {
        closePopup(C22ndflrblk3);
    });

    C22ndflrblck4.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C22ndflrblk4, C22blk4A, C22blk4B);
    });
    C22blk4closePopup.addEventListener('click', function() {
        closePopup(C22ndflrblk4);
    });
    
    C21stflrblck3.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C21stflrblk3, C2S2blk3A, C2S2blk3B);
    });
    C2S2closePopupblk3.addEventListener('click', function() {
        closePopup(C21stflrblk3);
    });

    C21stflrblck4.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C21stflrblk4, C2S2blk4A, C2S2blk4B);
    });
    C2S2closePopupblk4.addEventListener('click', function() {
        closePopup(C21stflrblk4);
    });

    C12ndflrblck3.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C12ndblk3, C12ndflrblk3A, C12ndflrblk3B);
    });
    C12ndclosePopupblk3.addEventListener('click', function() {
        closePopup(C12ndblk3);
    });

    C12ndflrblck4.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C12ndblk4, C12ndflrblk4A, C12ndflrblk4B);
    });
    C12ndclosePopupblk4.addEventListener('click', function() {
        closePopup(C12ndblk4);
    });

    //BLKl
    C11stflrSA.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C11stS1, C11stflrSSA, C11stflrSSB);
    });
    C12ndflrSB.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C12ndS2, C12ndS2flrSSA, C12ndS2flrSSB);
    });
    C12ndflrSA.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C12ndS, C12ndflrSSA, C12ndflrSSB);
    });
    C12ndflr.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C12nd, C12ndflrSA, C12ndflrSB);
    });
    C11stflr.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C11st, C11stflrSA, C11stflrSB);
    });
    C21stflr.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C21st, C21stflrSA, C21stflrSB);
    });
    C22ndflr.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C22nd, C22ndflrSA, C22ndflrSB);
    });
    C2trigger.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C2, C21stflr, C22ndflr);
    });
    C1trigger.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(C1, C11stflr, C12ndflr);
    });
    A1trigger.addEventListener('click', function(event) {
    event.preventDefault();
    openPopup(A1, A1sideA, A1sideB);
});

    A2trigger.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(A2, A2sideA, A2sideB);
    });
    A3trigger.addEventListener('click', function(event) {
        event.preventDefault();
        openPopup(A3, A3sideA, A3sideB);
    });
    
    

    C22S2closePopup.addEventListener('click', function() {
        closePopup(C22ndflrS2);
    });
    C22S1closePopup.addEventListener('click', function() {
        closePopup(C22ndflrS1);
    });

    C2S2closePopup.addEventListener('click', function() {
        closePopup(C21stflrS2);
    });

    C2S1closePopup.addEventListener('click', function() {
        closePopup(C21stflrS1);
    });
    
    C11stclosePopupS2.addEventListener('click', function() {
        closePopup(C11stS2);
    });
    C11stclosePopupS.addEventListener('click', function() {
        closePopup(C11stS1);
    });
    C12ndclosebuttonS2.addEventListener('click', function() {
        closePopup(C12ndS2);
    });
    C12ndclosePopupS.addEventListener('click', function() {
        closePopup(C12ndS);
    });
    C1closeButton.addEventListener('click', function() {
        closePopup(C1);
    });
    C2closeButton.addEventListener('click', function() {
        closePopup(C2);
    });
    C1closePopup2nd.addEventListener('click', function() {
        closePopup(C12nd);
    });
    
    C1closePopup1st.addEventListener('click', function() {
        closePopup(C11st);
    });
    C2closePopup1st.addEventListener('click', function() {
        closePopup(C21st);
    });
    C2closePopup2nd.addEventListener('click', function() {
        closePopup(C22nd);
    });
   
    A1closeButton.addEventListener('click', function() {
    closePopup(A1);
});
    A2closeButton.addEventListener('click', function() {
        closePopup(A2);
    });
    A3closeButton.addEventListener('click', function() {
        closePopup(A3);
    });



    document.addEventListener('click', function(event) {

        if (idluke.style.display === 'block' && !idluke.contains(event.target) && event.target !== lukebtn) {
            closePopup(idluke);
        }
        if (idluke.classList.contains('show') && !idluke.contains(event.target) && event.target !== lukebtn) {
        closePopup(idluke);
        }

        if (idmark.style.display === 'block' && !idmark.contains(event.target) && event.target !== markbtn) {
            closePopup(idmark);
        }
        if (idmark.classList.contains('show') && !idmark.contains(event.target) && event.target !== markbtn) {
        closePopup(idmark);
        }

        if (iddominic.style.display === 'block' && !iddominic.contains(event.target) && event.target !== dominicbtn) {
            closePopup(iddominic);
        }
        if (iddominic.classList.contains('show') && !iddominic.contains(event.target) && event.target !== dominicbtn) {
        closePopup(iddominic);
        }

        if (idisidore.style.display === 'block' && !idisidore.contains(event.target) && event.target !== isidorebtn) {
            closePopup(idisidore);
        }
        if (idisidore.classList.contains('show') && !idisidore.contains(event.target) && event.target !== isidorebtn) {
        closePopup(idisidore);
        }

        if (idpm.style.display === 'block' && !idpm.contains(event.target) && event.target !== Michaelbtn) {
            closePopup(idpm);
        }
        if (idpm.classList.contains('show') && !idpm.contains(event.target) && event.target !== Michaelbtn) {
        closePopup(idpm);
        }
        if (idmatthew.style.display === 'block' && !idmatthew.contains(event.target) && event.target !== Matthewbtn) {
            closePopup(idmatthew);
        }
        if (idmatthew.classList.contains('show') && !idmatthew.contains(event.target) && event.target !== Matthewbtn) {
        closePopup(idmatthew);
        }
        if (idjude.style.display === 'block' && !idjude.contains(event.target) && event.target !== judebtn) {
            closePopup(idjude);
        }
        if (idjude.classList.contains('show') && !idjude.contains(event.target) && event.target !== judebtn) {
        closePopup(idjude);
        }

        if (idjohn.style.display === 'block' && !idjohn.contains(event.target) && event.target !== johnbtn) {
            closePopup(idjoseph);
        }
        if (idjohn.classList.contains('show') && !idjohn.contains(event.target) && event.target !== johnbtn) {
        closePopup(idjohn);
        }

        if (idjoseph.style.display === 'block' && !idjoseph.contains(event.target) && event.target !== josephbtn) {
            closePopup(idjoseph);
        }
        if (idjoseph.classList.contains('show') && !idjoseph.contains(event.target) && event.target !== josephbtn) {
        closePopup(idjoseph);
        }

        if (idjames.style.display === 'block' && !idjames.contains(event.target) && event.target !== jamesbtn) {
            closePopup(idjames);
        }
        if (idjames.classList.contains('show') && !idjames.contains(event.target) && event.target !== jamesbtn) {
        closePopup(idjames);
        }

        if (idagustine.style.display === 'block' && !idagustine.contains(event.target) && event.target !== Agustinebtn) {
            closePopup(idagustine);
        }
        if (idagustine.classList.contains('show') && !idagustine.contains(event.target) && event.target !== Agustinebtn) {
        closePopup(idagustine);
        }
        
        if (idpaul.style.display === 'block' && !idpaul.contains(event.target) && event.target !== Paulbtn) {
            closePopup(idpaul);
        }
        if (idpaul.classList.contains('show') && !idpaul.contains(event.target) && event.target !== Paulbtn) {
        closePopup(idpaul);
        }

        if (idpeter.style.display === 'block' && !idpeter.contains(event.target) && event.target !== Peterbtn) {
            closePopup(idpeter);
        }
        if (idpeter.classList.contains('show') && !idpeter.contains(event.target) && event.target !== Peterbtn) {
        closePopup(idpeter);
        }


        if (idRAF.style.display === 'block' && !idRAF.contains(event.target) && event.target !== Rafaelbtn) {
            closePopup(idRAF);
        }
        if (idRAF.classList.contains('show') && !idRAF.contains(event.target) && event.target !== Rafaelbtn) {
        closePopup(idRAF);
        }

        
        if (C22ndflrS2.style.display === 'block' && !C22ndflrS2.contains(event.target) && event.target !== C22ndflrSB) {
            closePopup(C22ndflrS2);
        }
        if (C22ndflrS2.classList.contains('show') && !C22ndflrS2.contains(event.target) && event.target !== C22ndflrSB) {
        closePopup(C22ndflrS2);
        }

        if (C22ndflrS1.style.display === 'block' && !C22ndflrS1.contains(event.target) && event.target !== C22ndflrSA) {
            closePopup(C22ndflrS1);
        }
        if (C22ndflrS1.classList.contains('show') && !C22ndflrS1.contains(event.target) && event.target !== C22ndflrSA) {
        closePopup(C22ndflrS1);
        }

        if (C21stflrS2.style.display === 'block' && !C21stflrS2.contains(event.target) && event.target !== C21stflrSB) {
            closePopup(C21stflrS2);
        }
        if (C21stflrS2.classList.contains('show') && !C21stflrS2.contains(event.target) && event.target !== C21stflrSB) {
        closePopup(C21stflrS2);
        }
        
        if (C21stflrS1.style.display === 'block' && !C21stflrS1.contains(event.target) && event.target !== C21stflrSA) {
            closePopup(C21stflrS1);
        }
        if (C21stflrS1.classList.contains('show') && !C21stflrS1.contains(event.target) && event.target !== C21stflrSA) {
        closePopup(C21stflrS1);
        }

        
        if (C11stS2.style.display === 'block' && !C11stS2.contains(event.target) && event.target !== C11stflrSB) {
            closePopup(C11stS2);
        }
        if (C11stS2.classList.contains('show') && !C11stS2.contains(event.target) && event.target !== C11stflrSB) {
        closePopup(C11stS2);
        }
//BLK
        if (C11stblk3.style.display === 'block' && !C11stblk3.contains(event.target) && event.target !== C11stflrblk3) {
            closePopup(C11stblk3);
        }
        if (C11stblk3.classList.contains('show') && !C11stblk3.contains(event.target) && event.target !== C11stflrblk3) {
        closePopup(C11stblk3);
        }
        if (C11stblk4.style.display === 'block' && !C11stblk4.contains(event.target) && event.target !== C11stflrblk4) {
            closePopup(C11stblk4);
        }
        if (C11stblk4.classList.contains('show') && !C11stblk4.contains(event.target) && event.target !== C11stflrblk4) {
        closePopup(C11stblk4);
        }
        if (C22ndflrblk3.style.display === 'block' && !C22ndflrblk3.contains(event.target) && event.target !== C22ndflrblck3) {
            closePopup(C22ndflrblk3);
        }
        if (C22ndflrblk3.classList.contains('show') && !C22ndflrblk3.contains(event.target) && event.target !== C22ndflrblck3) {
        closePopup(C22ndflrblk3);
        }

        if (C22ndflrblk4.style.display === 'block' && !C22ndflrblk4.contains(event.target) && event.target !== C22ndflrblck4) {
            closePopup(C22ndflrblk4);
        }
        if (C22ndflrblk4.classList.contains('show') && !C22ndflrblk4.contains(event.target) && event.target !== C22ndflrblck4) {
        closePopup(C22ndflrblk4);
        }

        if (C21stflrblk3.style.display === 'block' && !C21stflrblk3.contains(event.target) && event.target !== C21stflrblck3) {
            closePopup(C21stflrblk3);
        }
        if (C21stflrblk3.classList.contains('show') && !C21stflrblk3.contains(event.target) && event.target !== C21stflrblck3) {
        closePopup(C21stflrblk3);
        }


        if (C21stflrblk4.style.display === 'block' && !C21stflrblk4.contains(event.target) && event.target !== C21stflrblck4) {
            closePopup(C21stflrblk4);
        }
        if (C21stflrblk4.classList.contains('show') && !C21stflrblk4.contains(event.target) && event.target !== C21stflrblck4) {
        closePopup(C21stflrblk4);
        }

        if (C12ndblk3.style.display === 'block' && !C12ndblk3.contains(event.target) && event.target !== C12ndflrblck3) {
            closePopup(C12ndblk3);
        }
        if (C12ndblk3.classList.contains('show') && !C12ndblk3.contains(event.target) && event.target !== C12ndflrblck3) {
        closePopup(C12ndblk3);
        }

        if (C12ndblk4.style.display === 'block' && !C12ndblk4.contains(event.target) && event.target !== C12ndflrblck4) {
            closePopup(C12ndblk4);
        }
        if (C12ndblk4.classList.contains('show') && !C12ndblk4.contains(event.target) && event.target !== C12ndflrblck4) {
        closePopup(C12ndblk4);
        }
        
        
//BLK
//BLK
        
        if (C11stS1.style.display === 'block' && !C11stS1.contains(event.target) && event.target !== C11stflrSA) {
            closePopup(C11stS1);
        }
        if (C11stS1.classList.contains('show') && !C11stS1.contains(event.target) && event.target !== C11stflrSA) {
        closePopup(C11stS1);
        }
        if (C12ndS2.style.display === 'block' && !C12ndS2.contains(event.target) && event.target !== C12ndflrSB) {
            closePopup(C12ndS2);
        }
        if (C12ndS2.classList.contains('show') && !C12ndS2.contains(event.target) && event.target !== C12ndflrSB) {
        closePopup(C12ndS2);
        }
        if (C12ndS.style.display === 'block' && !C12ndS.contains(event.target) && event.target !== C12ndflrSA) {
            closePopup(C12ndS);
        }
        if (C12ndS.classList.contains('show') && !C12ndS.contains(event.target) && event.target !== C12ndflrSA) {
        closePopup(C12ndS);
        }
        if (C1.style.display === 'block' && !C1.contains(event.target) && event.target !== C1trigger) {
            closePopup(C1);
        }
        if (C1.classList.contains('show') && !C1.contains(event.target) && event.target !== C1trigger) {
        closePopup(C1);
        }
        
        if (C11st.style.display === 'block' && !C11st.contains(event.target) && event.target !== C11stflr) {
            closePopup(C11st);
        }
        if (C11st.classList.contains('show') && !C11st.contains(event.target) && event.target !== C11stflr) {
        closePopup(C11st);
        }
        if (C12nd.style.display === 'block' && !C12ndd.contains(event.target) && event.target !== C12ndflr) {
            closePopup(C12nd);
        }
        if (C12nd.classList.contains('show') && !C12nd.contains(event.target) && event.target !== C12ndflr) {
        closePopup(C12nd);
        }
        if (C21st.style.display === 'block' && !C21st.contains(event.target) && event.target !== C21stflr) {
            closePopup(C21st);
        }
        if (C21st.classList.contains('show') && !C21st.contains(event.target) && event.target !== C21stflr) {
        closePopup(C21st);
        }
        if (C22nd.style.display === 'block' && !C22nd.contains(event.target) && event.target !== C22ndflr) {
            closePopup(C22nd);
        }
        if (C22nd.classList.contains('show') && !C22nd.contains(event.target) && event.target !== C22ndflr) {
        closePopup(C22nd);
        }
        if (C2.style.display === 'block' && !C2.contains(event.target) && event.target !== C2trigger) {
            closePopup(C2);
        }
        if (C2.classList.contains('show') && !C2.contains(event.target) && event.target !== C2trigger) {
        closePopup(C2);
        }
        if (A1.style.display === 'block' && !A1.contains(event.target) && event.target !== A1trigger) {
            closePopup(A1);
        }
        if (A1.classList.contains('show') && !A1.contains(event.target) && event.target !== A1trigger) {
        closePopup(A1);
        }
        if (A2.style.display === 'block' && !A2.contains(event.target) && event.target !== A2trigger) {
            closePopup(A2);
        }
        if (A2.classList.contains('show') && !A2.contains(event.target) && event.target !== A2trigger) {
        closePopup(A2);
        }
        if (A3.style.display === 'block' && !A3.contains(event.target) && event.target !== A3trigger) {
            closePopup(A3);
        }
        if (A3.classList.contains('show') && !A3.contains(event.target) && event.target !== A3trigger) {
        closePopup(A3);
        }
        
    });
});
//hides all the button/label saints
document.addEventListener('DOMContentLoaded', function() {

const Paiyakanbtn = document.getElementById('Paiyakan');
const paiyakanclosebtn = document.getElementById('closePanel');

const Luke = document.getElementById('Luke');
const IDlukeclosebtn = document.getElementById('IDlukeclosebtn');

const Mark = document.getElementById('Mark');
const IDmarkclosebtn = document.getElementById('IDmarkclosebtn');

const Dominic = document.getElementById('Dominic');
const IDdominicclosebtn = document.getElementById('IDdominicclosebtn');

const Isidore= document.getElementById('Isidore');
const IDisidoreclosebtn = document.getElementById('IDisidoreclosebtn');

const Michael= document.getElementById('Michael');
const IDpmclosebtn = document.getElementById('IDpmclosebtn');

const Matthew= document.getElementById('Matthew');
const IDmatthewclosebtn = document.getElementById('IDmatthewclosebtn');

const Jude= document.getElementById('Jude');
const IDjudeclosebtn = document.getElementById('IDjudeclosebtn');

const John= document.getElementById('John');
const IDjohnclosebtn = document.getElementById('IDjohnclosebtn');

const Joseph = document.getElementById('Joseph');
const IDjosephclosebtn = document.getElementById('IDjosephclosebtn');

const James = document.getElementById('James');
const IDjamesclosebtn = document.getElementById('IDjamesclosebtn');

const Agustine = document.getElementById('Agustine');
const IDagustineclosebtn = document.getElementById('IDagustineclosebtn');

const Paul = document.getElementById('Paul');
const IDpaulclosebtn = document.getElementById('IDpaulclosebtn');

const Peter = document.getElementById('Peter');
const IDpeterclosebtn = document.getElementById('IDpeterclosebtn');

const Rafael = document.getElementById('Rafael');
const IDRAFaclosebtn = document.getElementById('IDRAFaclosebtn');

const C22ndflrSB = document.getElementById('C22ndflrSB');
const C22S2closePopup = document.getElementById('C22S2closePopup');

const C22ndflrSA = document.getElementById('C22ndflrSA');
const C22S1closePopup = document.getElementById('C22S1closePopup');

const C21stflrSB = document.getElementById('C21stflrSB');
const C2S2closePopup = document.getElementById('C2S2closePopup');

const C21stflrSA = document.getElementById('C21stflrSA');
const C2S1closePopup = document.getElementById('C2S1closePopup');



const C11stflrS2SA = document.getElementById('C11stflrS2SA');
const C11stclosePopupS2 = document.getElementById('C11stclosePopupS2');
    
const C11stflrSB = document.getElementById('C11stflrSB');
const C12ndclosePopupS2 = document.getElementById('C12ndclosePopupS2');
    
const C11stflrSA = document.getElementById('C11stflrSA');
const C11stclosePopupS = document.getElementById('C11stclosePopupS');

const C12ndflrSB = document.getElementById('C12ndflrSB');
const C12ndclosebuttonS2 = document.getElementById('C12ndclosebuttonS2');

const C12ndflrSA = document.getElementById('C12ndflrSA');
const C12ndclosePopupS = document.getElementById('C12ndclosePopupS');

const Colum1 = document.getElementById('Colum1');
const C1closePopup = document.getElementById('C1closePopup');

const Colum2 = document.getElementById('Colum2');
const C2closePopup = document.getElementById('C2closePopup');

const C11st = document.getElementById('C11st');
const C1closePopup1st = document.getElementById('C1closePopup1st');

const C12nd = document.getElementById('C12nd');
const C1closePopup2nd = document.getElementById('C1closePopup2nd');

const C21st = document.getElementById('C21st');
const C2closePopup1st = document.getElementById('C2closePopup1st');

const C22nd = document.getElementById('C22nd');
const C2closePopup2nd = document.getElementById('C2closePopup2nd');

const Apart1 = document.getElementById('Apart1');
const A1closePopup = document.getElementById('A1closePopup');

const Apart3 = document.getElementById('Apart3');
const A3closePopup = document.getElementById('A3closePopup');

const Apart2 = document.getElementById('Apart2');
const A2closePopup = document.getElementById('A2closePopup');



const labels = [
    document.getElementById('Isidore'),
    document.getElementById('Joseph'),
    document.getElementById('Jude'),
    document.getElementById('John'),
    document.getElementById('Paul'),
    document.getElementById('Peter'),
    document.getElementById('Matthew'),
    document.getElementById('Dominic'),
    document.getElementById('Agustine'),
    document.getElementById('Rafael'),
    document.getElementById('Mark'),
    document.getElementById('Luke'),
    document.getElementById('Michael'),

    document.getElementById('Apart1'),
    document.getElementById('Apart2'),
    document.getElementById('Apart3'),
    document.getElementById('Colum1'),
    document.getElementById('Colum2'),

    document.getElementById('responsiveImage'),
    document.getElementById('James')
    
    
];
function blurLabels() {
        labels.forEach(label => label.style.filter = 'blur(5px)');
    }

    // Remove blur from the labels
    function clearBlurLabels() {
        labels.forEach(label => label.style.filter = 'none');
    }
    
    Paiyakanbtn.addEventListener('click', function() {
    blurLabels(); 
});
paiyakanclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Luke.addEventListener('click', function() {
    blurLabels(); 
});
IDlukeclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Mark.addEventListener('click', function() {
    blurLabels(); 
});
IDmarkclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
Dominic.addEventListener('click', function() {
    blurLabels(); 
});
IDdominicclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
Isidore.addEventListener('click', function() {
    blurLabels(); 
});
IDisidoreclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Michael.addEventListener('click', function() {
    blurLabels(); 
});
IDpmclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
Matthew.addEventListener('click', function() {
    blurLabels(); 
});
IDmatthewclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Jude.addEventListener('click', function() {
    blurLabels(); 
});
IDjudeclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
John.addEventListener('click', function() {
    blurLabels(); 
});
IDjohnclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
Joseph.addEventListener('click', function() {
    blurLabels(); 
});
IDjosephclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
James.addEventListener('click', function() {
    blurLabels(); 
});
IDjamesclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Agustine.addEventListener('click', function() {
    blurLabels(); 
});
IDagustineclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});
Paul.addEventListener('click', function() {
    blurLabels(); 
});
IDpaulclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Peter.addEventListener('click', function() {
    blurLabels(); 
});
IDpeterclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});

Rafael.addEventListener('click', function() {
    blurLabels(); 
});
IDRAFaclosebtn.addEventListener('click', function() {
    clearBlurLabels();
});





C11stflrS2SA.addEventListener('click', function() {
    blurLabels(); 
});
C11stclosePopupS2.addEventListener('click', function() {
    blurLabels();
});

C22ndflrSA.addEventListener('click', function() {
    blurLabels(); 
});
C22S1closePopup.addEventListener('click', function() {
    blurLabels();
});

C21stflrSB.addEventListener('click', function() {
    blurLabels(); 
});
C2S2closePopup.addEventListener('click', function() {
    blurLabels();
});

C21stflrSA.addEventListener('click', function() {
    blurLabels(); 
});
C2S1closePopup.addEventListener('click', function() {
    blurLabels();
});

C11stflrSA.addEventListener('click', function() {
    blurLabels(); 
});
C12ndflrSB.addEventListener('click', function() {
    blurLabels(); 
});

C12ndflrSA.addEventListener('click', function() {
    blurLabels(); 
});
C12ndflrSA.addEventListener('click', function() {
    blurLabels(); 
});

Colum1.addEventListener('click', function() {
    blurLabels(); 
});
C12ndclosePopupS.addEventListener('click', function() {
    blurLabels();
});
C11stclosePopupS.addEventListener('click', function() {
    blurLabels();
});
C1closePopup.addEventListener('click', function() {
    clearBlurLabels();
});
Colum2.addEventListener('click', function() {
    blurLabels(); 
});
C12nd.addEventListener('click', function() {
    blurLabels(); 
});
C11st.addEventListener('click', function() {
    blurLabels(); 
});
C21st.addEventListener('click', function() {
    blurLabels(); 
});
C2closePopup1st.addEventListener('click', function() {
    blurLabels(); 
});
C22nd.addEventListener('click', function() {
    blurLabels(); 
});
C2closePopup2nd.addEventListener('click', function() {
    blurLabels(); 
});
C12ndclosePopupS2.addEventListener('click', function() {
    blurLabels();
});
C2closePopup2nd.addEventListener('click', function() {
    clearBlurLabels();
});

C1closePopup1st.addEventListener('click', function() {
    clearBlurLabels();
});
C1closePopup2nd.addEventListener('click', function() {
    clearBlurLabels();
});
C2closePopup1st.addEventListener('click', function() {
    clearBlurLabels();
});
C2closePopup.addEventListener('click', function() {
    clearBlurLabels();
});

Apart3.addEventListener('click', function() {
    blurLabels(); 
});
A3closePopup.addEventListener('click', function() {
    clearBlurLabels();
});
Apart2.addEventListener('click', function() {
    blurLabels(); 
});
A2closePopup.addEventListener('click', function() {
    clearBlurLabels(); 
});
Apart1.addEventListener('click', function() {
    blurLabels(); 
});
A1closePopup.addEventListener('click', function() {
    clearBlurLabels(); 
});
});
//shows the lots in apartment
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        popup.classList.add('open'); 
    }, 10); 
    setTimeout(function() {
        popup.style.display = 'none'; 
        popup.classList.remove('close');
    }, 600); 

const Luke = document.getElementById('Luke');
const idluke = document.getElementById('idluke');
const IDlukeclosebtn = document.getElementById('IDlukeclosebtn');

const Mark = document.getElementById('Mark');
const idmark = document.getElementById('idmark');
const IDmarkclosebtn = document.getElementById('IDmarkclosebtn');

const Dominic = document.getElementById('Dominic');
const iddominic = document.getElementById('iddominic');
const IDdominicclosebtn = document.getElementById('IDdominicclosebtn');

const Isidore = document.getElementById('Isidore');
const idisidore = document.getElementById('idisidore');
const IDisidoreclosebtn = document.getElementById('IDisidoreclosebtn');

const Michael=document.getElementById('Michael');
const idpm = document.getElementById('idpm');
const IDpmclosebtn = document.getElementById('IDpmclosebtn');

const Matthew=document.getElementById('Matthew');
const idmatthew = document.getElementById('idmatthew');
const IDmatthewclosebtn = document.getElementById('IDmatthewclosebtn');

const Jude=document.getElementById('Jude');
const idjude = document.getElementById('idjude');
const IDjudeclosebtn = document.getElementById('IDjudeclosebtn');

const John=document.getElementById('John');
const idjohn = document.getElementById('idjohn');
const IDjohnclosebtn = document.getElementById('IDjohnclosebtn');

const Joseph =document.getElementById('Joseph');
const idjoseph = document.getElementById('idjoseph');
const IDjosephclosebtn = document.getElementById('IDjosephclosebtn');
    
const James = document.getElementById('James');
const idjames = document.getElementById('idjames');
const IDjamesclosebtn = document.getElementById('IDjamesclosebtn');

const Paul = document.getElementById('Paul');
const idpaul = document.getElementById('idpaul');
const IDpaulclosebtn = document.getElementById('IDpaulclosebtn');

const Peter= document.getElementById('Peter');
const idpeter = document.getElementById('idpeter');
const IDpeterclosebtn = document.getElementById('IDpeterclosebtn');

const Rafael = document.getElementById('Rafael');
const idRAF = document.getElementById('idRAF');
const IDRAFaclosebtn = document.getElementById('IDRAFaclosebtn');

const C12ndS2flrS1SBbtn = document.getElementById('C12ndflrSSB');
const C1GRIDS1B = document.getElementById('C1GRIDS1B');
const C1GRIDS1BcloseButton = document.getElementById('C1GRIDS1BclosePopup');

//-

const C22ndS2flrS22Bbtn = document.getElementById('C22SB2');
const C2GRIDS22B = document.getElementById('C2GRIDS22B');
const C2GRIDS22BcloseButton = document.getElementById('C2GRIDS22BclosePopup');

const C22ndS2flrS22Abtn = document.getElementById('C22SA2');
const C2GRIDS22A = document.getElementById('C2GRIDS22A');
const C2GRIDS22AcloseButton = document.getElementById('C2GRIDS22AclosePopup');

const C22ndS2flrS12SBbtn = document.getElementById('C22SB');
const C2GRIDS12B = document.getElementById('C2GRIDS12B');
const C2GRIDS12BcloseButton = document.getElementById('C2GRIDS12BclosePopup');

const C22ndS2flrS12SAbtn = document.getElementById('C22SA');
const C2GRIDS12A = document.getElementById('C2GRIDS12A');
const C2GRIDS12AcloseButton = document.getElementById('C2GRIDS12AclosePopup');

const C22ndS2flrS2SBbtn = document.getElementById('C2S2SB');
const C2GRIDS2B = document.getElementById('C2GRIDS2B');
const C2GRIDS2BcloseButton = document.getElementById('C2GRIDS2BclosePopup');

const C22ndS2flrS2SAbtn = document.getElementById('C2S2SA');
const C2GRIDS2A = document.getElementById('C2GRIDS2A');
const C2GRIDS2AcloseButton = document.getElementById('C2GRIDS2AclosePopup');


const C22ndS2flrS1SBbtn = document.getElementById('C2S1SB');
const C2GRIDS1B = document.getElementById('C2GRIDS1B');
const C2GRIDS1BcloseButton = document.getElementById('C2GRIDS1BclosePopup');


const C22ndS2flrS1SAbtn = document.getElementById('C2S1SA');
const C2GRIDS1A = document.getElementById('C2GRIDS1A');
const C2GRIDS1AcloseButton = document.getElementById('C2GRIDS1AclosePopup');



//blk
const C22ndS2flrblk3Abtn = document.getElementById('C2S2blk3A');
const C2GRIDblk3A = document.getElementById('C2GRIDblk3A');
const C2GRIDblk3AcloseButton = document.getElementById('C2GRIDblk3AclosePopup');

const C22ndS2flrblk3Bbtn = document.getElementById('C2S2blk3B');
const C2GRIDblk3B = document.getElementById('C2GRIDblk3B');
const C2GRIDblk3BcloseButton = document.getElementById('C2GRIDblk3BclosePopup');

const C22ndS2flrblk4Abtn = document.getElementById('C2S2blk4A');
const C2GRIDblk4A = document.getElementById('C2GRIDblk4A');
const C2GRIDblk4AcloseButton = document.getElementById('C2GRIDblk4AclosePopup');

const C22ndS2flrblk4Bbtn = document.getElementById('C2S2blk4B');
const C2GRIDblk4B = document.getElementById('C2GRIDblk4B');
const C2GRIDblk4BcloseButton = document.getElementById('C2GRIDblk4BclosePopup');
//a
const C22ndflrblk3Abtn = document.getElementById('C22blk3A');
const C2blk3GRID = document.getElementById('C2blk3GRID');
const C2blk3AGRIDcloseButton = document.getElementById('C2blk3GRIDclosePopup');

const C22ndflrblk3Bbtn = document.getElementById('C22blk3B');
const C2blk3BGRID = document.getElementById('C2blk3BGRID');
const C2blk3BGRIDcloseButton = document.getElementById('C2blk3BGRIDclosePopup');

const C22ndflrblk4Abtn = document.getElementById('C22blk4A');
const C2blk4AGRID = document.getElementById('C2blk4AGRID');
const C2blk4AGRIDcloseButton = document.getElementById('C2blk4AGRIDclosePopup');

const C22ndflrblk4Bbtn = document.getElementById('C22blk4B');
const C2blk4BGRID = document.getElementById('C2blk4BGRID');
const C2blk4BGRIDcloseButton = document.getElementById('C2blk4BGRIDclosePopup');


const C22ndflrBLK3Abtn = document.getElementById('C11stflrblk3A');
const C1GRIDBLK3A = document.getElementById('C1GRIDBLK3A');
const C2BLK3AGRIDcloseButton = document.getElementById('C1GRIDBLK3AclosePopup');

const C22ndflrBLK3Bbtn = document.getElementById('C11stflrblk3B');
const C1GRIDBLK3B = document.getElementById('C1GRIDBLK3B');
const C2BLK3BGRIDcloseButton = document.getElementById('C1GRIDBLK3BclosePopup');

const C22ndflrBLK4Abtn = document.getElementById('C11stflrblk4A');
const C1GRIDBLK4A = document.getElementById('C1GRIDBLK4A');
const C2BLK4AGRIDcloseButton = document.getElementById('C1GRIDBLK4AclosePopup');


const C22ndflrBLK4Bbtn = document.getElementById('C11stflrblk4B');
const C1GRIDBLK4B = document.getElementById('C1GRIDBLK4B');
const C2BLK4BGRIDcloseButton = document.getElementById('C1GRIDBLK4BclosePopup');


const C12ndflrblk3A = document.getElementById('C12ndflrblk3A');
const C1blk3A2ndGRID = document.getElementById('C1blk3A2ndGRID');
const C2blk3A2ndGRIDcloseButton = document.getElementById('C1blk3A2ndGRIDclosePopup');


const C12ndflrblk3B = document.getElementById('C12ndflrblk3B');
const C1blk3B2ndGRID = document.getElementById('C1blk3B2ndGRID');
const C2blk3B2ndGRIDcloseButton = document.getElementById('C1blk3B2ndGRIDclosePopup');

const C12ndflrblk4A = document.getElementById('C12ndflrblk4A');
const C1blk4A2ndGRID = document.getElementById('C1blk4A2ndGRID');
const C2blk4A2ndGRIDcloseButton = document.getElementById('C1blk4A2ndGRIDclosePopup');

const C12ndflrblk4B = document.getElementById('C12ndflrblk4B');
const C1blk4B2ndGRID = document.getElementById('C1blk4B2ndGRID');
const C2blk4B2ndGRIDcloseButton = document.getElementById('C1blk4B2ndGRIDclosePopup');




const C11stS2flrS22BSBbtn = document.getElementById('C11stflrS2SB');
const C1GRIDS22B = document.getElementById('C1GRIDS22B');
const C1GRIDS22BclosePopup = document.getElementById('C1GRIDS22BclosePopup');

const C11stS2flrS22ASBbtn = document.getElementById('C11stflrS2SA');
const C1GRIDS22A = document.getElementById('C1GRIDS22A');
const C1GRIDS22AclosePopup = document.getElementById('C1GRIDS22AclosePopup');

const C11stS2flrS11SBbtn = document.getElementById('C11stflrSSB');
const C1GRIDS11B = document.getElementById('C1GRIDS11B');
const C1GRIDS11BclosePopup = document.getElementById('C1GRIDS11BclosePopup');

const C11stS2flrS11SAbtn = document.getElementById('C11stflrSSA');
const C1GRIDS11A = document.getElementById('C1GRIDS11A');
const C1GRIDS11AclosePopup = document.getElementById('C1GRIDS11AclosePopup');


const C12ndS2flrS1SAbtn = document.getElementById('C12ndflrSSA');
const C1GRIDS1A = document.getElementById('C1GRIDS1A');
const C1GRIDS1AcloseButton = document.getElementById('C1GRIDS1AclosePopup');
    
const C12ndS2flrSSBbtn = document.getElementById('C12ndS2flrSSB');
const C1GRIDSB = document.getElementById('C1GRIDSB');
const C1GRIDSBcloseButton = document.getElementById('C1GRIDSBclosePopup');
    
const C12ndS2flrSSAbtn = document.getElementById('C12ndS2flrSSA');
const C1GRIDSA = document.getElementById('C1GRIDSA');
const C1GRIDSAcloseButton = document.getElementById('C1GRIDSAclosePopup');


const sideAButton = document.getElementById('A1sideA');
const sideAa1 = document.getElementById('sideAa1');
const closeButton = document.getElementById('AA1closePopup');

const sideBButton = document.getElementById('A1sideB');
const sideBa1 = document.getElementById('sideBa1');
const closeBButton = document.getElementById('BA1closePopup');

const sideA2Button = document.getElementById('A2sideA');
const sideAa2 = document.getElementById('sideAa2');
const closeA2Button = document.getElementById('AA2closePopup');

const sideB2Button = document.getElementById('A2sideB');
const sideBa2 = document.getElementById('sideBa2');
const closeB2Button = document.getElementById('BA2closePopup');

const sideA3Button = document.getElementById('A3sideA');
const sideAa3 = document.getElementById('sideAa3');
const closeA3Button = document.getElementById('AA3closePopup');

const sideB3Button = document.getElementById('A3sideB');
const sideBa3 = document.getElementById('sideBa3');
const closeB3Button = document.getElementById('BA3closePopup');
//apart
closeButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa1.classList.add('exit');
    setTimeout(() => {
        sideAa1.classList.remove('active'); 
        sideAa1.classList.remove('exit'); 
    }, 300); 
});
closeBButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa1.classList.add('exit');
    setTimeout(() => {
        sideBa1.classList.remove('active'); 
        sideBa1.classList.remove('exit'); 
    }, 300); 
});
closeA2Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa2.classList.add('exit');
    setTimeout(() => {
        sideAa2.classList.remove('active'); 
        sideAa2.classList.remove('exit'); 
    }, 300); 
});
closeB2Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa2.classList.add('exit');
    setTimeout(() => {
        sideBa2.classList.remove('active'); 
        sideBa2.classList.remove('exit'); 
    }, 300); 
});
closeA3Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa3.classList.add('exit');
    setTimeout(() => {
        sideAa3.classList.remove('active'); 
        sideAa3.classList.remove('exit'); 
    }, 300); 
});
closeB3Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa3.classList.add('exit');
    setTimeout(() => {
        sideBa3.classList.remove('active'); 
        sideBa3.classList.remove('exit'); 
    }, 300); 
});
IDlukeclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idluke.classList.add('exit');
    setTimeout(() => {
        idluke.classList.remove('active'); 
        idluke.classList.remove('exit'); 
    }, 300); 
});

//BTN  CLOSE
Luke.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idluke.classList.add('active'); 
});



Mark.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idmark.classList.add('active'); 
});

IDmarkclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idmark.classList.remove('active');
});

Dominic.addEventListener('click', function(event) {
    event.stopPropagation(); 
    iddominic.classList.add('active'); 
});

IDdominicclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    iddominic.classList.remove('active');
});


Isidore.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idisidore.classList.add('active'); 
});

IDisidoreclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idisidore.classList.remove('active');
});

Michael.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpm.classList.add('active'); 
});

IDpmclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpm.classList.remove('active');
});


Matthew.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idmatthew.classList.add('active'); 
});

IDmatthewclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idmatthew.classList.remove('active');
});

Jude.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjude.classList.add('active'); 
});

IDjudeclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjude.classList.remove('active');
});


John.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjohn.classList.add('active'); 
});

IDjohnclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjohn.classList.remove('active');
});

Joseph.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjoseph.classList.add('active'); 
});

IDjosephclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjoseph.classList.remove('active');
});

James.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjames.classList.add('active'); 
});

IDjamesclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idjames.classList.remove('active');
});

Paul.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpaul.classList.add('active'); 
});

IDpaulclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpaul.classList.remove('active');
});

Peter.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpeter.classList.add('active'); 
});

IDpeterclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idpaul.classList.remove('active');
});

Rafael.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idRAF.classList.add('active'); 
});

IDRAFaclosebtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    idRAF.classList.remove('active');
});



C12ndS2flrS1SBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS1B.classList.add('active'); 
});

C1GRIDS1BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS1B.classList.remove('active');
});

//-

C22ndS2flrS22Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS22B.classList.add('active'); 
});

C2GRIDS22BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS22B.classList.remove('active');
});

C22ndS2flrS22Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS22A.classList.add('active'); 
});

C2GRIDS22AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS22A.classList.remove('active');
});
C22ndS2flrS12SBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS12B.classList.add('active'); 
});

C2GRIDS12BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS12B.classList.remove('active');
});

C22ndS2flrS12SAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS12A.classList.add('active'); 
});

C2GRIDS12AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS12A.classList.remove('active');
});

C22ndS2flrS2SBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS2B.classList.add('active'); 
});

C2GRIDS2BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS2B.classList.remove('active');
});

C22ndS2flrS2SAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS2A.classList.add('active'); 
});

C2GRIDS2AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS2A.classList.remove('active');
});

C22ndS2flrS1SBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS1B.classList.add('active'); 
});

C2GRIDS1BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS1B.classList.remove('active');
});

C22ndS2flrS1SAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS1A.classList.add('active'); 
});

C2GRIDS1AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDS1A.classList.remove('active');
});

C22ndS2flrblk3Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk3A.classList.add('active'); 
});

C2GRIDblk3AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk3A.classList.remove('active');
});

C22ndS2flrblk3Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk3B.classList.add('active'); 
});

C2GRIDblk3BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk3B.classList.remove('active');
});

C22ndS2flrblk4Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk4A.classList.add('active'); 
});

C2GRIDblk4AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk4A.classList.remove('active');
});

C22ndS2flrblk4Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk4B.classList.add('active'); 
});

C2GRIDblk4BcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2GRIDblk4B.classList.remove('active');
});

C22ndflrblk3Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk3GRID.classList.add('active'); 
});

C2blk3AGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk3GRID.classList.remove('active');
});

C22ndflrblk3Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk3BGRID.classList.add('active'); 
});

C2blk3BGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk3BGRID.classList.remove('active');
});

C22ndflrblk4Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk4AGRID.classList.add('active'); 
});

C2blk4AGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk4AGRID.classList.remove('active');
});

C22ndflrblk4Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk4BGRID.classList.add('active'); 
});

C2blk4BGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C2blk4BGRID.classList.remove('active');
});


C22ndflrBLK3Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK3A.classList.add('active'); 
});

C2BLK3AGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK3A.classList.remove('active');
});

C22ndflrBLK3Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK3B.classList.add('active'); 
});

C2BLK3BGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK3B.classList.remove('active');
});

C22ndflrBLK4Abtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK4A.classList.add('active'); 
});

C2BLK4AGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK4A.classList.remove('active');
});

C22ndflrBLK4Bbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK4B.classList.add('active'); 
});

C2BLK4BGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDBLK4B.classList.remove('active');
});

C12ndflrblk3A.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk3A2ndGRID.classList.add('active'); 
});

C2blk3A2ndGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk3A2ndGRID.classList.remove('active');
});


C12ndflrblk3B.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk3B2ndGRID.classList.add('active'); 
});

C2blk3B2ndGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk3B2ndGRID.classList.remove('active');
});


C12ndflrblk4A.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk4A2ndGRID.classList.add('active'); 
});

C2blk4A2ndGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk4A2ndGRID.classList.remove('active');
});

C12ndflrblk4B.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk4B2ndGRID.classList.add('active'); 
});

C2blk4B2ndGRIDcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1blk4B2ndGRID.classList.remove('active');
});
//

C11stS2flrS22BSBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS22B.classList.add('active'); 
});

C1GRIDS22BclosePopup.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS22B.classList.remove('active');
});

C11stS2flrS22ASBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS22A.classList.add('active'); 
});

C1GRIDS22AclosePopup.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS22A.classList.remove('active');
});

C11stS2flrS11SBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS11B.classList.add('active'); 
});

C1GRIDS11BclosePopup.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS11B.classList.remove('active');
});

C11stS2flrS11SAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS11A.classList.add('active'); 
});

C1GRIDS11AclosePopup.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS11A.classList.remove('active');
});

C12ndS2flrS1SAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS1A.classList.add('active'); 
});

C1GRIDS1AcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDS1A.classList.remove('active');
});


C12ndS2flrSSBbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDSB.classList.add('active'); 
});

C1GRIDSBcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDSB.classList.remove('active');
});


C12ndS2flrSSAbtn.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDSA.classList.add('active'); 
});

C1GRIDSAcloseButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    C1GRIDSA.classList.remove('active');
});


sideAButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa1.classList.add('active'); 
});


sideBButton.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa1.classList.add('active'); 
});


sideA2Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa2.classList.add('active'); 
});


sideB2Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa2.classList.add('active'); 
});



sideA3Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideAa3.classList.add('active'); 
});



sideB3Button.addEventListener('click', function(event) {
    event.stopPropagation(); 
    sideBa3.classList.add('active'); 
});


});


document.addEventListener('DOMContentLoaded', () => {
    fetch('fetch_all_records.php')
        .then(response => response.json())
        .then(records => {
            console.log("Fetched records:", records);

            // Create a map for faster lookups
            const recordMap = new Map();
            records.forEach(record => {
                const key = `${record.Lot_No.trim()}_${record.mem_sts.trim()}`;
                recordMap.set(key, true);
            });

            const classes = ['grid-itemA3', 'grid-itemB3', 'grid-itemA2', 'grid-itemB2', 'grid-itemA', 'grid-itemB',
                'grid-itemC2S1A', 'grid-itemC2S1B', 'grid-itemC2S2A', 'grid-itemC2S2B', 'grid-itemC2S12A', 'grid-itemC2S12B',
                'grid-itemC2S22A', 'grid-itemC2S22B', 'grid-itemC1S1A', 'grid-itemC1S1B', 'grid-itemC1SA', 'grid-itemC1SB',
                'grid-itemRAF', 'grid-itempeter', 'grid-itempaul', 'grid-itemjude', 'grid-itemjohn', 'grid-itemjoseph',
                'grid-itemjames', 'grid-itemmatthew', 'grid-itemagustine', 'grid-itemdominic', 'grid-itemmark', 'grid-itemluke',
                'grid-itemisidore', 'grid-itemC2blk3A', 'grid-itemC2blk3B', 'grid-itemC2blk4A', 'grid-itemC2blk4B', 'grid-itemblk3AC2',
                'grid-itemblk3BC2', 'grid-itemblk4AC2', 'grid-itemblk4BC2', 'grid-itemC1S11A', 'grid-itemC1S11B',
                'grid-itemC1S22A', 'grid-itemC1S22B', 'grid-itemC1BLK3A', 'grid-itemC1BLK3B', 'grid-itemC1BLK4A',
                'grid-itemC1BLK4B', 'grid-itemC1blk3A2nd', 'grid-itemC1blk3B2nd', 'grid-itemC1blk4A2nd', 'grid-itemC1blk4B2nd', 'grid-itempm'];
            
            // Initialize results object with each class having matched and unmatched properties
            const results = {};
            classes.forEach(cls => {
                results[cls] = { matched: 0, unmatched: 0 };
            });

            // Map section IDs to their corresponding grid-item classes
            const sectionMapping = {
                'Paul': ['grid-itempaul'],
                'Mark': ['grid-itemmark'],
                'Joseph': ['grid-itemjoseph'],
                'Peter': ['grid-itempeter'],
                'Rafael': ['grid-itemRAF'],
                'Jude': ['grid-itemjude'],
                'Agustine': ['grid-itemagustine'],
                'Isidore': ['grid-itemisidore'],
                'John': ['grid-itemjohn'],
                'Matthew': ['grid-itemmatthew'],
                'Luke': ['grid-itemluke'],
                'Dominic': ['grid-itemdominic'],
                'James': ['grid-itemjames'],
                'Michael': ['grid-itempm'],
                'Apart3': ['grid-itemA3', 'grid-itemB3'],
                'Apart2': ['grid-itemA2', 'grid-itemB2'],
                'Apart1': ['grid-itemA', 'grid-itemB'],
                'Colum2': [
                    'grid-itemC2S1A', 'grid-itemC2S1B', 'grid-itemC2S2A', 'grid-itemC2S2B',
                    'grid-itemC2blk3A', 'grid-itemC2blk3B', 'grid-itemC2blk4A', 'grid-itemC2blk4B',
                    'grid-itemC2S12A', 'grid-itemC2S12B', 'grid-itemC2S22A', 'grid-itemC2S22B',
                    'grid-itemblk3AC2', 'grid-itemblk3BC2', 'grid-itemblk4AC2', 'grid-itemblk4BC2'
                ],
                'Colum1': [
                    'grid-itemC1S11A', 'grid-itemC1S11B', 'grid-itemC1S22A', 'grid-itemC1S22B',
                    'grid-itemC1BLK3A', 'grid-itemC1BLK3B', 'grid-itemC1BLK4A', 'grid-itemC1BLK4B',
                    'grid-itemC1blk3A2nd', 'grid-itemC1blk3B2nd', 'grid-itemC1blk4A2nd', 'grid-itemC1blk4B2nd',
                    'grid-itemC1S1A', 'grid-itemC1S1B', 'grid-itemC1SA', 'grid-itemC1SB'
                ]
            };

            // Create tooltip element
            const tooltip = document.createElement('div');
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 14px;
                pointer-events: none;
                display: none;
                z-index: 1000;
                max-width: 300px;
                word-wrap: break-word;
            `;
            document.body.appendChild(tooltip);

            // Process each section
            Object.entries(sectionMapping).forEach(([sectionId, gridClasses]) => {
                let totalUnmatched = 0;
                let totalLots = 0;

                // Process each grid class for the section
                gridClasses.forEach(gridClass => {
                    document.querySelectorAll(`.${gridClass}`).forEach(item => {
                        const lotNo = item.getAttribute('data-lotno')?.trim();
                        const memSts = item.getAttribute('data-memsts')?.trim();

                        totalLots++;

                        if (lotNo && memSts) {
                            const key = `${lotNo}_${memSts}`;
                            const recordExists = recordMap.has(key);

                            if (recordExists) {
                                item.style.backgroundColor = 'blue';
                                results[gridClass].matched++;
                            } else {
                                item.style.backgroundColor = 'green';
                                results[gridClass].unmatched++;
                                totalUnmatched++;
                            }

                            item.addEventListener('click', event => {
                                console.log('Clicked item:', {
                                    lotNo: event.target.getAttribute('data-lotno'),
                                    memSts: event.target.getAttribute('data-memsts'),
                                    memLot: event.target.getAttribute('data-memlot')
                                });
                            });
                        } else {
                            item.style.backgroundColor = 'green';
                            results[gridClass].unmatched++;
                            totalUnmatched++;
                        }
                    });
                });

                const sectionDiv = document.getElementById(sectionId);
                if (sectionDiv) {
                    sectionDiv.addEventListener('mouseenter', (e) => {
                        tooltip.style.display = 'block';
                        tooltip.textContent = `Available Lots/Slots: ${totalUnmatched}`;

                        const updateTooltipPosition = (event) => {
                            tooltip.style.left = `${event.pageX + 10}px`;
                            tooltip.style.top = `${event.pageY + 10}px`;
                        };

                        updateTooltipPosition(e);
                        sectionDiv.addEventListener('mousemove', updateTooltipPosition);
                    });

                    sectionDiv.addEventListener('mouseleave', () => {
                        tooltip.style.display = 'none';
                        sectionDiv.onmousemove = null;
                    });

                    sectionDiv.style.cursor = 'pointer';
                }
            });

            console.log("Results:", results);

            // Send data to PHP
            fetch('admin_display_results.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(results),
            })
                .then(response => response.text())
                .then(data => {
                    console.log("Results received from PHP:", data);
                    document.getElementById('results').innerHTML = data;
                })
                .catch(error => console.error('Error sending data to PHP:', error));
        })
        .catch(error => console.error('Error fetching records:', error));
});

// Create the popup div
const popup = document.createElement('div');
popup.id = 'noRecordPopup';
popup.style.position = 'fixed';
popup.style.top = '50%';
popup.style.left = '50%';
popup.style.transform = 'translate(-50%, -50%)';
popup.style.padding = '50px  60px';
popup.style.backgroundColor = '#071c14';
popup.style.color = 'white';
popup.style.borderRadius = '8px';
popup.style.fontSize = '2rem';
popup.style.textAlign = 'center';
popup.style.opacity = '0'; // Initially hidden
popup.style.zIndex = '1000';
popup.style.transition = 'opacity 0.5s ease';
popup.innerText = 'No record exists';

// Append the popup to the body
document.body.appendChild(popup);

// Function to show the popup with animation
function showPopup() {
  popup.style.display = 'block';
  popup.style.animation = 'popupFade 2.7s ease forwards';
  
  
  // Automatically remove the popup after the animation ends
  setTimeout(() => {
    popup.style.display = 'none';
  }, 2000); // Duration matches the animation
}

// Example usage: Call showPopup to show the popup
showPopup();

// Add keyframes using JavaScript
const styleSheet = document.createElement('style');
styleSheet.type = 'text/css';
styleSheet.innerText = `
  @keyframes popupFade {
    0% {
      transform: translate(-50%, -50%) scale(0.8);
      opacity: 0;
    }
    50% {
      transform: translate(-50%, -50%) scale(1.1);
      opacity: 1;
    }
    100% {
      transform: translate(-50%, -50%) scale(1);
      opacity: 0;
    }
  }
`;
document.head.appendChild(styleSheet);



// for the border color of the lots and blocks
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    const searchButton = document.querySelector('.btn-search');

    function clearHighlights() {
        // Clear all highlights by removing the highlight-border class
        document.querySelectorAll('[data-lotno]').forEach(item => {
            item.classList.remove('highlight-border');
        });

        document.querySelectorAll('.Paul, .Mark, .Apart1, .Apart2, .Apart3, ' +
            '#A3sideA, #A3sideB, #A2sideA, #A2sideB, #A1sideA, #A1sideB, ' +
            '.Joseph, .Peter, .Rafael, .Jude, .Agustine, .Isidore, .John, ' +
            '.Matthew, .Luke, .Dominic, .James, .Colum2, .Colum1, .Michael,' +
            '#C21stflrSA, #C21stflr, #C2S1SA, #C2S1SB, #C21stflrSB, #C21stflrblck3, ' +
            '#C2S2SA, #C2S2SB, #C2S2blk3A, #C2S2blk3B, #C21stflrblck4, #C2S2blk4A, ' +
            '#C22ndflr, #C22ndflrSA, #C22SA, #C22SB, #C22ndflrSB, #C22SA2, #C22SB2, ' +
            '#C22ndflrblck3, #C22blk3A, #C22blk3B, #C22ndflrblck4, #C22blk4A, #C22blk4B, ' +
            '#C11stflr, #C11stflrSA, #C11stflrSSA, #C11stflrSSB, #C11stflrSB, #C11stflrS2SB, ' +
            '#C11stflrS2SA, #C11stflrblk3, #C11stflrblk3B, #C11stflrblk3A, #C11stflrblk4, ' +
            '#C11stflrblk4B, #C11stflrblk4A, #C12ndflr, #C12ndflrSA, #C12ndflrSSB, ' +
            '#C12ndflrSSA, #C12ndflrSB, #C12ndS2flrSSB, #C12ndS2flrSSA, #C12ndflrblck3, ' +
            '#C12ndflrblk3A, #C12ndflrblk3B, #C12ndflrblck4, #C12ndflrblk4A, #C12ndflrblk4B').forEach(item => {
            item.classList.remove('highlight-border');
        });
    }

    function highlightMatchingRecords() {
        const searchValue = searchInput.value.trim().toLowerCase();
        document.getElementById('suggestions').style.display = 'none';
        // If the search input is empty, remove highlights and exit
        if (!searchValue) {
            clearHighlights();
            return;
        }

        // Fetch matching records from the database
        fetch('search_record.php?name=' + encodeURIComponent(searchValue))
            .then(response => response.json())
            .then(records => {
                console.log("Fetched records:", records);
                clearHighlights();
                if (records.length === 0) {
                    popup.style.display = 'block'; // Show popup if no records
                    setTimeout(() => popup.style.display = 'none', 3000); // Hide after 3 seconds
                    return; // Stop further processing
                }

                clearHighlights(); // Clear previous highlights before applying new ones

                // Iterate through each div with the data-lotno attribute to check for matches
                document.querySelectorAll('[data-lotno]').forEach(item => {
                    const lotNo = item.getAttribute('data-lotno') ? item.getAttribute('data-lotno').trim() : '';
                    const memSts = item.getAttribute('data-memsts') ? item.getAttribute('data-memsts').trim().toLowerCase() : '';

                    // Check if any of the filtered records match the lotNo and memSts of the current item
                    const recordExists = records.some(record =>
                        record.Lot_No === lotNo && record.mem_sts.toLowerCase() === memSts
                    );

                    if (recordExists) {
                        console.log(`Match found for div with Lot_No: ${lotNo}, mem_sts: ${memSts}`);
                        item.classList.add('highlight-border'); // Highlight matched items with CSS class

                        // Call the new function to highlight the specific side based on class
                        highlightSidesBasedOnClass(item);

                        // Highlight specific divs with IDs based on memSts
                        if (memSts === 'st. paul') {
                            document.getElementById('Paul').classList.add('highlight-border');
                        } else if (memSts === 'st. mark') {
                            document.getElementById('Mark').classList.add('highlight-border');
                        } else if (memSts === 'apartment1') {
                            document.getElementById('Apart1').classList.add('highlight-border');
                        } else if (memSts === 'apartment2') {
                            document.getElementById('Apart2').classList.add('highlight-border');
                        } else if (memSts === 'apartment3') {
                            document.getElementById('Apart3').classList.add('highlight-border');
                        } else if (memSts === 'columbarium2') {
                            document.getElementById('Colum2').classList.add('highlight-border');
                        } else if (memSts === 'columbarium1') {
                            document.getElementById('Colum1').classList.add('highlight-border');
                        } else if (memSts === 'st. joseph') {
                            document.getElementById('Joseph').classList.add('highlight-border');
                        } else if (memSts === 'st. peter') {
                            document.getElementById('Peter').classList.add('highlight-border');
                        } else if (memSts === 'st. rafael') {
                            document.getElementById('Rafael').classList.add('highlight-border');
                        } else if (memSts === 'st. jude') {
                            document.getElementById('Jude').classList.add('highlight-border');
                        } else if (memSts === 'st. augustin') {
                            document.getElementById('Agustine').classList.add('highlight-border');
                        } else if (memSts === 'st. isidore') {
                            document.getElementById('Isidore').classList.add('highlight-border');
                        } else if (memSts === 'st. john') {
                            document.getElementById('John').classList.add('highlight-border');
                        } else if (memSts === 'st. matthew') {
                            document.getElementById('Matthew').classList.add('highlight-border');
                        } else if (memSts === 'st. lukes') {
                            document.getElementById('Luke').classList.add('highlight-border');
                        } else if (memSts === 'st. dominic') {
                            document.getElementById('Dominic').classList.add('highlight-border');
                        } else if (memSts === 'st. james') {
                            document.getElementById('James').classList.add('highlight-border');
                        } else if (memSts === 'st. patrick' || memSts === 'st. michael') {
                            document.getElementById('Michael').classList.add('highlight-border');
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching records for highlight function:', error));
    }

    // Function to highlight specific sides based on classes
    function highlightSidesBasedOnClass(matchedElement) {
        if (matchedElement.classList.contains('grid-itemA')) {
            document.getElementById('A1sideA').classList.add('highlight-border');
        }
        if (matchedElement.classList.contains('grid-itemB')) {
            document.getElementById('A1sideB').classList.add('highlight-border');
        }
        //////////////////Apartment 2 side A
        if (matchedElement.classList.contains('grid-itemA2')) {
            document.getElementById('A2sideA').classList.add('highlight-border');
        }

        // Check if the matched element has the class 'grid-itemB'
        //Apartment 2 side B
        if (matchedElement.classList.contains('grid-itemB2')) {
            document.getElementById('A2sideB').classList.add('highlight-border');
        }
        ///////////////// Apartment 3 side A
        if (matchedElement.classList.contains('grid-itemA3')) {
            document.getElementById('A3sideA').classList.add('highlight-border');
        }

        // Check if the matched element has the class 'grid-itemB'
        //Apartment 3 side B
        if (matchedElement.classList.contains('grid-itemB3')) {
            document.getElementById('A3sideB').classList.add('highlight-border');
        }
        ///////////////

        // Columbarium 2 1st floor 


        //Columbarium 2 1st floor block 1 side A
        if (matchedElement.classList.contains('grid-itemC2S1A')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrSA').classList.add('highlight-border');//block
            document.getElementById('C2S1SA').classList.add('highlight-border');//side
        }
     //Columbarium 2 1st floor block 1 side B
        if (matchedElement.classList.contains('grid-itemC2S1B')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrSA').classList.add('highlight-border');//block
            document.getElementById('C2S1SB').classList.add('highlight-border');//side
        }
            ///columbarium 2 1st floor block 2 side A
        if (matchedElement.classList.contains('grid-itemC2S2A')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrSB').classList.add('highlight-border');//block
            document.getElementById('C2S2SA').classList.add('highlight-border');//side
        }
        //Columbarium 2 1st floor block 2 side B
        if (matchedElement.classList.contains('grid-itemC2S2B')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrSB').classList.add('highlight-border');//block
            document.getElementById('C2S2SB').classList.add('highlight-border');//side
        }
        //Columbarium 2 1st floor block 3 side A
        if (matchedElement.classList.contains('grid-itemC2blk3A')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrblck3').classList.add('highlight-border');//block
            document.getElementById('C2S2blk3A').classList.add('highlight-border');//side
        }
        //Columbarium 2 1st floor block 3 side B
        if (matchedElement.classList.contains('grid-itemC2blk3B')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrblck3').classList.add('highlight-border');//block
            document.getElementById('C2S2blk3B').classList.add('highlight-border');//side
        }
        //Columbarium 2 1st floor block 4 side A
        if (matchedElement.classList.contains('grid-itemC2blk4A')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrblck4').classList.add('highlight-border');//block
            document.getElementById('C2S2blk4A').classList.add('highlight-border');//side
        }
        //Columbarium 2 1st floor block 4 side B
        if (matchedElement.classList.contains('grid-itemC2blk4B')) {
            document.getElementById('C21stflr').classList.add('highlight-border');//floor
            document.getElementById('C21stflrblck4').classList.add('highlight-border');//block
            document.getElementById('C2S2blk4B').classList.add('highlight-border');//side
        }

        //Columbarium 2 2nd floor

        //Columbarium 2 2nd floor block 1 side A
        if (matchedElement.classList.contains('grid-itemC2S12A')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrSA').classList.add('highlight-border');//block
            document.getElementById('C22SA').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 1 side B
        if (matchedElement.classList.contains('grid-itemC2S12B')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrSA').classList.add('highlight-border');//block
            document.getElementById('C22SB').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 2 Side A
        if (matchedElement.classList.contains('grid-itemC2S22A')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrSB').classList.add('highlight-border');//block
            document.getElementById('C22SA2').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 2 Side B
        if (matchedElement.classList.contains('grid-itemC2S22B')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrSB').classList.add('highlight-border');//block
            document.getElementById('C22SB2').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 3 side A aguisgdu
        if (matchedElement.classList.contains('grid-itemblk3AC2')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrblck3').classList.add('highlight-border');//block
            document.getElementById('C22blk3A').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 3 side B
        if (matchedElement.classList.contains('grid-itemblk3BC2')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrblck3').classList.add('highlight-border');//block
            document.getElementById('C22blk3B').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 4 side A
        if (matchedElement.classList.contains('grid-itemblk4AC2')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrblck4').classList.add('highlight-border');//block
            document.getElementById('C22blk4A').classList.add('highlight-border');//side
        }
        //Columbarium 2 2nd floor block 4 side B
        if (matchedElement.classList.contains('grid-itemblk4BC2')) {
            document.getElementById('C22ndflr').classList.add('highlight-border');//floor
            document.getElementById('C22ndflrblck4').classList.add('highlight-border');//block
            document.getElementById('C22blk4B').classList.add('highlight-border');//side
        }



        // Columbarium 1 1st floor 

        //Columbarium 1 1st floor block 1 side A
        if (matchedElement.classList.contains('grid-itemC1S11A')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrSA').classList.add('highlight-border');//block
            document.getElementById('C11stflrSSA').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 1 side B
        if (matchedElement.classList.contains('grid-itemC1S11B')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrSA').classList.add('highlight-border');//block
            document.getElementById('C11stflrSSB').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 2 side A
        if (matchedElement.classList.contains('grid-itemC1S22A')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrSB').classList.add('highlight-border');//block
            document.getElementById('C11stflrS2SA').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 2 side B
        if (matchedElement.classList.contains('grid-itemC1S22B')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrSB').classList.add('highlight-border');//block
            document.getElementById('C11stflrS2SB').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 3 side A
        if (matchedElement.classList.contains('grid-itemC1BLK3A')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrblk3').classList.add('highlight-border');//block
            document.getElementById('C11stflrblk3A').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 3 side B
        if (matchedElement.classList.contains('grid-itemC1BLK3B')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrblk3').classList.add('highlight-border');//block
            document.getElementById('C11stflrblk3B').classList.add('highlight-border');//side
        }
        //Columbarium 1 1st floor block 4 side A
        if (matchedElement.classList.contains('grid-itemC1BLK4A')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrblk4').classList.add('highlight-border');//block
            document.getElementById('C11stflrblk4A').classList.add('highlight-border');//side
        }
        //Colubarium 1 1st floor block 4 side B
        if (matchedElement.classList.contains('grid-itemC1BLK4B')) {
            document.getElementById('C11stflr').classList.add('highlight-border');//floor
            document.getElementById('C11stflrblk4').classList.add('highlight-border');//block
            document.getElementById('C11stflrblk4B').classList.add('highlight-border');//side
        }



        //Columbarium 1 2nd floor block 1 side A
        if (matchedElement.classList.contains('grid-itemC1S1A')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrSA').classList.add('highlight-border');//block
            document.getElementById('C12ndflrSSA').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 1 side B
        if (matchedElement.classList.contains('grid-itemC1S1B')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrSA').classList.add('highlight-border');//block
            document.getElementById('C12ndflrSSB').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 2 side A
        if (matchedElement.classList.contains('grid-itemC1SA')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrSB').classList.add('highlight-border');//block
            document.getElementById('C12ndS2flrSSA').classList.add('highlight-border');//side
        }
        //Columbarium 1  2nd floor block 2 side B
        if (matchedElement.classList.contains('grid-itemC1SB')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrSB').classList.add('highlight-border');//block
            document.getElementById('C12ndS2flrSSB').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 3 side A
        if (matchedElement.classList.contains('grid-itemC1blk3A2nd')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrblck3').classList.add('highlight-border');//block
            document.getElementById('C12ndflrblk3A').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 3 side B
        if (matchedElement.classList.contains('grid-itemC1blk3B2nd')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrblck3').classList.add('highlight-border');//block
            document.getElementById('C12ndflrblk3B').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 4 side A
        if (matchedElement.classList.contains('grid-itemC1blk4A2nd')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrblck4').classList.add('highlight-border');//block
            document.getElementById('C12ndflrblk4A').classList.add('highlight-border');//side
        }
        //Columbarium 1 2nd floor block 4 side B
        if (matchedElement.classList.contains('grid-itemC1blk4B2nd')) {
            document.getElementById('C12ndflr').classList.add('highlight-border');//floor
            document.getElementById('C12ndflrblck4').classList.add('highlight-border');//block
            document.getElementById('C12ndflrblk4B').classList.add('highlight-border');//side
        }
    }


    // Attach the search function to the search button click event
    searchButton.addEventListener('click', highlightMatchingRecords);

    // Add input event listener to searchInput to clear highlights in real-time
    searchInput.addEventListener("input", () => {
        if (searchInput.value.trim() === "") {
            clearHighlights();
        }
    });

    
    searchInput.addEventListener('input', function () {
        if (searchInput.value) {
            clearButton.style.display = 'block'; // Show clear button
        } else {
            clearButton.style.display = 'none'; // Hide clear button
        }
    });

    // Clear the input field when the clear button is clicked
    clearButton.addEventListener('click', function () {
        searchInput.value = ''; // Clear the input
        clearButton.style.display = 'none'; // Hide the clear button
        searchInput.focus(); // Optionally focus back on the input
        document.getElementById("suggestions").style.display = "none";
        clearHighlights();
    });
    
});

//autocomplete name suggestion document.getElementById('searchInput').addEventListener('input', function() {
    document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value;

    if (query.length > 0) {
        fetch('autocomplete.php?q=' + query)
            .then(response => response.json())
            .then(data => {
                let suggestions = '';
                data.forEach(name => {
                    suggestions += `<div class="suggestion-item" onclick="selectName('${name}')">${name}</div>`;
                });
                document.getElementById('suggestions').innerHTML = suggestions;
                document.getElementById('suggestions').style.display = 'block'; // Show suggestions
            });
    } else {
        document.getElementById('suggestions').innerHTML = '';
        document.getElementById('suggestions').style.display = 'none'; // Hide suggestions
    }
});

function selectName(name) {
    document.getElementById('searchInput').value = name;
    document.getElementById('suggestions').innerHTML = '';
    document.getElementById('suggestions').style.display = 'none'; // Hide suggestions
}


//Loading screen
document.addEventListener("DOMContentLoaded", function() {
            // Ensure loader is displayed immediately on DOM load
            document.getElementById("loader").style.display = "flex";
      
        });

        // Hide loader and show content after the page is fully loaded
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("loader").style.display = "none"; // Hide the loader
            }, 500);  // Optional small delay to force a repaint (can be adjusted or removed)
        });


// anti zooom 
    
        // Prevent zoom using wheel event
        document.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });

        // Prevent zoom using keydown events
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === '+' || e.key === '-' || e.key === '=')) {
                e.preventDefault();
            }
        });


             
    </script>
</body>
</html>
