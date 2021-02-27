function refresh_page(){
  location.reload();
}

var id;
var to;
// var from;
var strings;
var newSearch;
var viewer;
var name;
var currentNode;
var hotspots;
var hotSpotsIds=new Array();
var featureHotSpots=new Array();


loading();
function loading()
{
 if(id!=null)
     openModal(null,id);
     else {
       id=1;
       openModal(null,id);
     }
}



function  openModal(event,args){

from=args;


if(featureHotSpots.length!=0)
{
       manageHotSpots(args);
 }

       id=args;
       currentNode=args

var path = null;
       $.ajax({
         url: 'handleRequests.php',
         type: 'GET',
         data: {nodeId1: args},
         async: false,
         success: function (response) {
            path = response;

          //console.log(path);

         },
       });

  
  removeHotspots();
    viewer = pannellum.viewer('panorama', {
   "type": "equirectangular",
   "autoRotate": -6,
   "panorama": "/finalp/"+path,
   "hotSpots": gethotspots(args) ,
   "autoLoad": true,
  //  "stopAutoRotate":false,
    "yaw":getYawForNextNodeInPath(),
    //"yaw":0,
    "hfov":100

});

if(args==to)
   {
    
    setTimeout(function() { alert("you have arrived to your distination"); }, 1000);
  
   } 
}

function getYawForNextNodeInPath()
{

  
  if(featureHotSpots.length > 0){
    for(x in strings){
      if(featureHotSpots[0]==strings[x]['id'])
        return strings[x]['yaw']
    }
  }else if(featureHotSpots.length==0)
          {
            for(x in strings){
        
              if(strings[x]['name']!=null){ 
                var n = strings[x]['name'].replace("''",'"');
      
              if(name==strings[x]['name'] ||  name==n){
                 return strings[x]['yaw'];
              }
            }
          }
}
  return 0;
}
function removeHotspots()
{
  for(var i=0;i<hotSpotsIds.length;i++)
  {
    viewer.removeHotSpot(hotSpotsIds[i]);
  }
  hotSpotsIds=new Array();
}
function arrayRemove(arr, value) {
  var index = arr.indexOf(value);
if (index !== -1) arr.splice(index, 1);

}


function gethotspots(p1)
{
  //console.log("featureHotSpots :::");
  // console.log(featureHotSpots);

hotspots=new Array();
var newUs ="createTooltipFunc" ;
var newValue= hotspot;
var newUs1 ="createTooltipArgs" ;
var newValue1= "";
var newUs2 ="clickHandlerFunc" ;
var newValue2= openModal;
var newUs3 ="cssClass";
var newValue3="park-hot-spot hs-park-overview";
var newValue32="custom-hotspot";
var newValue33="custom-hotspot-here";
var newValue34="custom-hotspot-green-grave";
// var newValue32="custom-hotspot-grave";


     strings=new Array();
    $.ajax({
            url: 'handleRequests.php',
            type: 'POST',
            data: {node1: id},
            async: false,
            success: function(response){
              hotspots=response;
              //console.log(hotspots);
            },
            }
        );

        var jsons=hotspots.split('*');
        jsons=jsons.filter(function (el) {
  return el != "";
});

        for(var i=0;i<jsons.length;i++)
        {
          var obj = JSON.parse(jsons[i]);
          obj[newUs]=newValue;
   
          if(obj['name']==null){

          obj[newUs1]=obj['id'];
          obj[newUs2]=newValue2;
          if(featureHotSpots[0]==obj[newUs1])
          {
                obj[newUs3]=newValue33;
          }else {
              obj[newUs3]=newValue3;
          }

        }
          else {

              obj[newUs1]=obj['name'];

             
             // if(obj[newUs1]==name)
             if(obj[newUs1]==name.replace('"', '\'\''))
              {
                auRo = 0;
                obj[newUs3]=newValue34;
              }
              else {
                obj[newUs3]=newValue32;
              }

          }

          strings.push(obj);
          hotSpotsIds.push(obj['id']);
        }
        return strings;
}

function manageHotSpots(args)
{
    if(featureHotSpots.length==0)
    return;
    else {
      var index = featureHotSpots.indexOf(args);
if (index==0) {
  currentNode=featureHotSpots[0];
  featureHotSpots.shift();
    }
    else {

      if(newSearch==0)
      {
        featureHotSpots.unshift(currentNode);
      }
      else {
        newSearch=0;
      }

  }
}

}

function getPath(Destination) {

//console.log("id ::");
//console.log(id);
  $.ajax({
    url: 'getPath.php',
    type: 'POST',
    data: {Destination: Destination,From:id
    },
    async: false,
    success: function (response) {
      //console.log(response);

  // var arr=response;
  // arr=response;
      console.log(response)
      var arr=response.substr(8);
      featureHotSpots=arr.split("\n");
      featureHotSpots.pop();
      featureHotSpots.pop();

      for (var i = 0; i < featureHotSpots.length; i++) {
        featureHotSpots[i]=parseInt(featureHotSpots[i].substring(featureHotSpots[i].indexOf(">")+1));
      }
      currentNode=featureHotSpots[0];/////////////////////////////////=============================================
      // featureHotSpots.shift();
      to=featureHotSpots[featureHotSpots.length-1];
  //console.log(to);

    // console.log(featureHotSpots);
    },
  });
  featureHotSpots.shift();
  // featureHotSpots.shift();
 // removeHotspots();

  if(featureHotSpots.length >= 1){
    openModal(null,currentNode);
  } else{
    openModal(null,1);
    alert("Record Not Found")
    /*setTimeout(refresh_page, 500); */


}
}

function getNodeByName()
{

     name = document.getElementById('search').value;
    
     console.log(name);
  $.ajax({
    url: 'handleRequests.php',
    type: 'POST',
    data: {name: name},
    async: false,
    error: function(xhr, status, error) {
      console.log(xhr)
      console.log(status)
      console.log(error)
    },
    success: function (response) {
      // console.log(response);

  // removeHotspots();
      newSearch=1;
      getPath(response);


    },
  });

}


function hotspot(hotSpotDiv, args) {

      // console.log(hotSpotDiv);
      // console.log("||||||||");
      // console.log(args);
         hotSpotDiv.classList.add('custom-tooltip');
         var span = document.createElement('span');
         span.innerHTML = args;
         hotSpotDiv.appendChild(span);
         span.style.width = span.scrollWidth - 20 + 'px';
         span.style.marginLeft = -(span.scrollWidth - hotSpotDiv.offsetWidth) / 2 + 'px';
         span.style.marginTop = -span.scrollHeight - 12 + 'px';
     }


