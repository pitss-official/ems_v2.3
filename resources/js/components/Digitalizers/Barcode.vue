<template>
    <div id="mainview">

    </div>
</template>

<script>
    import Quagga from 'quagga';
    let ele=document.querySelector('#mainview');
    export default {
        name: 'Barcode',
        data()
        {
            return {
                scanned:[],
            };
        },
        methods:{
          init()
          {
              Quagga.init({
                  numOfWorkers: 1,
                  frequency: 2,
                  locate:true,
                  debug: false,
                  inputStream : {
                      name : "Live",
                      type : "LiveStream",
                      target: '#mainview' ,
                      constraints: {
                          width: {min: 640},
                          height: {min: 480},
                          facingMode: "environment",
                          aspectRatio: {min: 1, max: 2}
                      },
                  },
                  decoder : {
                      readers : ["code_39_reader"],
                      debug: {
                          drawBoundingBox: true,
                          showFrequency: true,
                          drawScanline: true,
                          showPattern: true
                      },
                      multiple: false
                  },
                  locator:
                      {
                          halfSample: true,
                          patchSize: "small", // x-small, small, medium, large, x-large
                          debug: {
                              showCanvas: true,
                              showPatches: true,
                              showFoundPatches: true,
                              showSkeleton: true,
                              showLabels: true,
                              showPatchLabels: true,
                              showRemainingPatchLabels: true,
                              boxFromPatches: {
                                  showTransformed: true,
                                  showTransformedBox: true,
                                  showBB: true
                              }
                          }
                      }
              }, (err)=> {
                  if (err) {
                      Toast.fire({
                          type: 'error',
                          title: 'Camera Initialization Library Ran into exception',
                          confirmButtonText:'Retry'
                      }).then(()=>{location.reload()});
                      return
                  }
                  Quagga.onProcessed(function(result) {
                      var drawingCtx = Quagga.canvas.ctx.overlay,
                          drawingCanvas = Quagga.canvas.dom.overlay;

                      if (result) {
                          if (result.boxes) {
                              drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                              result.boxes.filter(function (box) {
                                  return box !== result.box;
                              }).forEach(function (box) {
                                  Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                              });
                          }

                          if (result.box) {
                              Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
                          }

                          if (result.codeResult && result.codeResult.code) {
                              Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
                          }
                      }
                  });
                  console.log("Initialization finished. Ready to start");
                  Quagga.onDetected((data)=>{
                      console.log(data);
                      Toast.fire({
                          type: 'info',
                          position: 'top-end',
                          title: 'Detected',
                          showConfirmButton: false,
                          timer:1000,
                      });
                      if(this.$data.scanned.includes(data.codeResult.code)){
                          Toast.fire({
                              type: 'info',
                              position: 'top-end',
                              title: 'Already Scanned and Processed',
                              showConfirmButton: false,
                              timer:1000,
                          });
                      }else
                      {
                          this.$data.scanned.push(data.codeResult.code);
                          Toast.fire({
                              type: 'success',
                              position: 'top-end',
                              title: data.codeResult.code,
                              showConfirmButton: false,
                              timer:1000,
                          });
                      }

                  });
                  Quagga.start();
              });
          }
        },
        mounted()
            {
                this.init()
            }
    }
</script>
<style scoped>
    #mainview
    {
        overflow:hidden;
        max-height: 200px;
    }
    </style>
