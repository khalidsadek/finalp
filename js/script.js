
// $(function(){


var id;
var to;
// var from;
var newSearch;
var viewer;
var name;
var currentNode;
var hotspots;
var hotSpotsIds=new Array();
// var previuseHotSpot=new Array();
var featureHotSpots=new Array();


loading();
// loadPoints()
function loading()
{
      // console.log(previuseHotSpot);
 if(id!=null)
     openModal(null,id);
     else {
       id=1;
       openModal(null,id);
     }
     //
     // openModal(null,1);
}


function  openModal(event,args){
console.log("==================================11====");
from=args;

console.log("args: ");
console.log(args);
console.log("}to : ");
console.log(to);

 // featureHotSpots.shift();
// if(args==to)
//    {
//      alert("you have arrived to your distination");
//    }
   // else {
console.log("newSearch :: ");
console.log(newSearch);
// if(newSearch==1)
// {
//   newSearch=0;
if(checkType()==0)
{
       manageHotSpots(args);
       console.log("in path");
 }

       id=args;
       currentNode=args


 //}

   // }
    // manageHotSpots(args);


  // id=args;

  // if(viewer!=null)
  removeHotspots();
    viewer = pannellum.viewer('panorama', {
   "type": "equirectangular",
   "autoRotate": -10,
   "panorama": "/finalp/images/"+args+".jpg",
   "hotSpots": gethotspots(args) ,
   "autoLoad": true,
   "stopAutoRotate":false,
   "hfov":150

});

// $( "div.panoramaTemp" ).replaceWith( $( ".panorama" ) );
if(args==to)
   {
     setTimeout(function() { alert("you have arrived to your distination"); }, 220);
    // alert("you have arrived to your distination");
   }
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
  console.log("featureHotSpots :::");
  console.log(featureHotSpots);

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
var newUs4="text";
var newValue4="come here";
var newvalue41="back";

    var strings=new Array();
    $.ajax({
            url: 'handleRequests.php',
            type: 'POST',
            data: {node1: id},
            async: false,
            success: function(response){
              hotspots=response;

            },
            }
        );

        console.log(hotspots);
        var jsons=hotspots.split('*');
        jsons=jsons.filter(function (el) {
  return el != "";
});

        for(var i=0;i<jsons.length;i++)
        {
          var obj = JSON.parse(jsons[i]);
          obj[newUs]=newValue;
          // obj[newUs2]=newValue2;
          // if(obj['cssClass']==null)
          if(obj['name']==null){
          // if(checkType()==1 || (checkType()==0 && featureHotSpots.indexOf(obj['id'])!=-1))
          // {
          obj[newUs1]=obj['id'];
          obj[newUs2]=newValue2;
          if(featureHotSpots[0]==obj[newUs1])
          {
                obj[newUs3]=newValue33;
          }else {
              obj[newUs3]=newValue3;
          }

          obj[newUs4]=newValue4;
        // }
        }
          else {
            // if(checkType()==0 && previuseHotSpot.indexOf(obj['id'])!=-1)
            // {
              obj[newUs1]=obj['name'];
              if(obj[newUs1]==name)
              {
                obj[newUs3]=newValue34;
              }
              else {
                obj[newUs3]=newValue32;
              }

              // obj[newUs4]=;
              // obj[newUs4]=newvalue41;
             // }
          }

          // }
          strings.push(obj);
          hotSpotsIds.push(obj['id']);
        }
        console.log(strings);
        return strings;
}

function manageHotSpots(args)
{
    if(checkType()==1)
    return;
    else {
      var index = featureHotSpots.indexOf(args);
if (index==0) {
  currentNode=featureHotSpots[0];
  featureHotSpots.shift();
    }
    else {
      console.log("manage From :: ");
      console.log(args);
      if(newSearch==0)
      {
        featureHotSpots.unshift(currentNode);
      }
      else {
        newSearch=0;
      }
      // featureHotSpots.unshift(currentNode);

  }
}

// console.log("featureHotSpots : ");
// console.log(featureHotSpots);
 // featureHotSpots.shift();

}

function getPath(Destination) {

console.log("id ::");
console.log(id);
  $.ajax({
    url: 'getPath.php',
    type: 'POST',
    data: {Destination: Destination,From:id
    },
    async: false,
    success: function (response) {
      console.log(response);

  // var arr=response;
  // arr=response;
 var  arr=response.substr(8);
  featureHotSpots=arr.split("\n");
  featureHotSpots.pop();
    featureHotSpots.pop();

    for (var i = 0; i < featureHotSpots.length; i++) {
    featureHotSpots[i]=parseInt(featureHotSpots[i].substring(featureHotSpots[i].indexOf(">")+1));
  }
  currentNode=featureHotSpots[0];/////////////////////////////////=============================================
  // featureHotSpots.shift();
  to=featureHotSpots[featureHotSpots.length-1];
  console.log(to);

    // console.log(featureHotSpots);

    },
  });
  featureHotSpots.shift();
  // featureHotSpots.shift();
 // removeHotspots();

 openModal(null,currentNode);

}


function getNodeByName()
{

   name = document.getElementById('search').value;

  $.ajax({
    url: 'handleRequests.php',
    type: 'POST',
    data: {name: name},
    async: false,
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

     function checkType()
       {
         // if(previuseHotSpot.length==0 && featureHotSpots.length==0)
         if(featureHotSpots.length==0)
         {
          console.log("checjType = 1");
           return 1;
}
  console.log("checjType = 0");
           return 0;

  }



// })
