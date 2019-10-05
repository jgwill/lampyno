// This file is building the container.
// three.js webgl - loaders - kicad pcb loader

var inserter_version = "1.2.2"

//var rotate = false; 
var cameraZ; var r;
var divId; var debug=false; // offs; speed;
// var cvname;

if ( WEBGL.isWebGLAvailable() === false ) {

    //document.body.appendChild( WEBGL.getWebGLErrorMessage() );
    divS = document.getElementById(cname);
    divS.appendChild( WEBGL.getWebGLErrorMessage() );

}
function showhide(divId) {
    var x = document.getElementById(divId);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
function hide(divId) {
    var x = document.getElementById(divId);
    x.style.display = "none";
}
function toggle_rotation () {
    rotate = ! rotate;
}

function zoom_refit (offset) {
    //console.log(offset);
    offset =  offset || 1.25;
    //r=cameraZ*offset;
    // camera.position.x= 0.45*offset; //-1.2; //0.0; //r*Math.cos(.1);
    // camera.position.z= 2.25*offset; //-7.9; //-8.0; //r*Math.sin(2);
    camera.position.x= cameraX*offset; //-1.2; //0.0; //r*Math.cos(.1);
    camera.position.y= cameraY*offset; //-1.2; //0.0; //r*Math.cos(.1);
    camera.position.z= cameraZ*offset; //-1.2; //0.0; //r*Math.cos(.1);
    //camera.position.x= camera.position.x*offset; //-1.2; //0.0; //r*Math.cos(.1);
    //camera.position.z= camera.position.z*offset; //-7.9; //-8.0; //r*Math.sin(2);
    camera.lookAt(scene.position);
    renderer.render( scene, camera );
}

// http://learningthreejs.com/data/THREEx/docs/THREEx.FullScreen.html
// function goFS (cvname) {
//     console.log(cvname);
//     divCV = document.getElementById(cvname);
//     console.log(divCV);
//     THREEx.FullScreen.request(divS);
// }
function degToRad(degrees)
{
  var pi = Math.PI;
  return degrees * (pi/180);
}
function zoom (offset) {
    offset =  offset || 1.25;
    //r=cameraZ*offset;
    // camera.position.x= 0.45*offset; //-1.2; //0.0; //r*Math.cos(.1);
    // camera.position.z= 2.25*offset; //-7.9; //-8.0; //r*Math.sin(2);
    camera.position.x= camera.position.x*offset; //-1.2; //0.0; //r*Math.cos(.1);
    camera.position.y= camera.position.y*offset; //-1.2; //0.0; //r*Math.cos(.1);
    camera.position.z= camera.position.z*offset; //-1.2; //0.0; //r*Math.cos(.1);
    //camera.position.x= camera.position.x*offset; //-1.2; //0.0; //r*Math.cos(.1);
    //camera.position.z= camera.position.z*offset; //-7.9; //-8.0; //r*Math.sin(2);
    camera.lookAt(scene.position);
    renderer.render( scene, camera );
}
function fitCameraToObject( camera, object, offset, controls ) {

    offset =  offset || 1.35;

    const boundingBox = new THREE.Box3();

    // get bounding box of object - this will be used to setup controls and camera
    boundingBox.setFromObject( object );
        
            //ERRORS HERE
    const center = boundingBox.getCenter();
    const size = boundingBox.getSize();

    // get the max side of the bounding box (fits to width OR height as needed )
    const maxDim = Math.max( size.x, size.y, size.z );
    const fov = camera.fov * ( Math.PI / 180 );
    cameraZ = Math.abs( maxDim / 2 * Math.tan( fov * 2 ) ); //Applied fifonik correction
    r=camera.position.z*offset;
    cameraZ *= offset; // zoom out a little so that objects don't fill the screen
    // console.log(cameraZ+' cameraZ' +' controls '+ controls)
    if (0) {
        zoom_refit (offset); //1.15); //(1.15);
    }
    else {
        // <--- NEW CODE
        //Method 1 to get object's world position
        scene.updateMatrixWorld(); //Update world positions
        var objectWorldPosition = new THREE.Vector3();
        objectWorldPosition.setFromMatrixPosition( object.matrixWorld );
        
        //Method 2 to get object's world position
        //objectWorldPosition = object.getWorldPosition();
    
        const directionVector = camera.position.sub(objectWorldPosition);   //Get vector from camera to object
        const unitDirectionVector = directionVector.normalize(); // Convert to unit vector
        camera.position = unitDirectionVector.multiplyScalar(cameraZ); //Multiply unit vector times cameraZ distance
        camera.lookAt(objectWorldPosition); //Look at object
        // --->
    
        const minZ = boundingBox.min.z;
        const cameraToFarEdge = ( minZ < 0 ) ? -minZ + cameraZ : cameraZ - minZ;
    
        camera.far = cameraToFarEdge * 3;
        camera.updateProjectionMatrix();
    
        if ( controls ) {
    
            // set camera to rotate around center of loaded object
            controls.target = center;
        
            // prevent camera from zooming out far enough to create far plane cutoff
            controls.maxDistance = cameraToFarEdge * 2;
                    // ERROR HERE   
            controls.saveState();
    
        } else {
            camera.lookAt( center )
        }
    }
    cameraX = camera.position.x
    cameraY = camera.position.y
    
}


var container; //var container, stats;
// var camera, controls, 
var scene, renderer;
var views = [];

// init();
// animate();
var model, cname, ar;

//FBX loader
var mixer;
var clock = new THREE.Clock();

//dae loader
// var dae_obj;


/* function View( canvas, fullWidth, fullHeight, viewX, viewY, viewWidth, viewHeight ) {

                canvas.width = viewWidth * window.devicePixelRatio;
                canvas.height = viewHeight * window.devicePixelRatio;

                var context = canvas.getContext( '2d' );

                var camera = new THREE.PerspectiveCamera( 20, viewWidth / viewHeight, 1, 10000 );
                camera.setViewOffset( fullWidth, fullHeight, viewX, viewY, viewWidth, viewHeight );
                camera.position.z = 1800;

                this.render = function () {

                    camera.position.x += ( mouseX - camera.position.x ) * 0.05;
                    camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
                    camera.lookAt( scene.position );

                    renderer.render( scene, camera );

                    context.drawImage( renderer.domElement, 0, 0 );

                };

            }
*/

function initTest(model) {
    model_url = model; //pathVar;
    model_name = model;
    console.log(model_name);
    modelExt = model.substring(model.lastIndexOf(".")+1)
    console.log(modelExt);
    modelName = model.substring(0,model.lastIndexOf("."))
    console.log(modelName);
    objName = modelName+'.obj'
    mtlName = modelName+'.mtl'
    console.log(objName);
    console.log(mtlName);
    
    //model_name = model_name.substring(model_url.lastIndexOf("/")+1);
    //console.log(model_name);
    //model_url = model_name.substring(0,model_url.lastIndexOf("/"));
    //console.log(model_url);
    
}

function init (model, cname, ar, ioffset, ground) {

    
    //views.push( new View( canvas1, fullWidth, fullHeight, w * 0, h * 0, w, h ) );

    //camera = new THREE.PerspectiveCamera( 60, window.innerWidth / window.innerHeight, 0.01, 1e10 );
    divS = document.getElementById(cname);
    camera = new THREE.PerspectiveCamera( 60, divS.clientWidth / (divS.clientWidth/ar), 0.01, 1e10 ); //   /ar, 0.01, 1e10 );
    //camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 2000 );
    camera.position.z = 6;

    //controls = new THREE.OrbitControls( camera , container );

    scene = new THREE.Scene();
    //scene.background = new THREE.Color( 0xF5F5F5 );
    // scene.background = new THREE.Color( 0xD9D9D9 );
    scene.background = new THREE.Color( jsbackcolor ); //0xD9D9D9 );
    // console.log(jsbackcolor);
    if (0) {
        scene.fog = new THREE.Fog( 0xD9D9D9, 2, 20 );
    }
    scene.add( camera );

    if (0) {  //ground
        // Ground
        var plane = new THREE.Mesh(
            new THREE.PlaneBufferGeometry( 40, 40 ),
            new THREE.MeshPhongMaterial( { color: 0x999999, specular: 0x101010 } )
        );
        plane.rotation.x = - Math.PI / 2;
        plane.position.y = - 10.0; //0.5;
        scene.add( plane );
        plane.receiveShadow = true;
    }
    
    // ground_offset = -10.0;
    if (ground==true) {  //ground
        var mesh = new THREE.Mesh( 
            new THREE.PlaneBufferGeometry( 2000, 2000 ), 
            new THREE.MeshPhongMaterial( { color: groundcolor, specular: 0x101010, depthWrite: false } )
        );
        mesh.rotation.x = - Math.PI / 2;
        mesh.receiveShadow = true;
        mesh.position.y = ground_offset; //0.5;
        scene.add( mesh );
    }
    if (grid == true) {  //grid
        // var grid = new THREE.GridHelper( 2000, 20, 0x000000, 0xFF0000 );
        // grid.material.opacity = 0.2;
        // grid.material.transparent = true;
        var gridXZ = new THREE.GridHelper(2000, 20);
        gridXZ.setColors( new THREE.Color(0x006600), new THREE.Color(0x006600) );
        gridXZ.position.set( 0,0,0 );
        gridXZ.position.y = ground_offset; //0.5;
        scene.add(gridXZ);
        // scene.add( grid );
    }
    
    //}
    
    
    // light

    if (1) {

        //var dirLight = new THREE.DirectionalLight( 0xffffff);
        var dirLight = new THREE.DirectionalLight( light_color, light_intensity );
        // dirLight.position.set( 200, 200, 1000 ).normalize();
        dirLight.position.set( lx, ly, lz ).normalize();
    
        camera.add( dirLight );
        camera.add( dirLight.target );
    }
    // var light = new THREE.AmbientLight( 0x404040 ); //  0x9D9D9D ); // soft white light
    var light = new THREE.AmbientLight( amb_light_color, amb_light_intensity ); //  light
    scene.add( light );
    
    if (0) {
        light = new THREE.HemisphereLight( 0xffffff, 0x444444 );
        light.position.set( 0, 200, 0 );
        scene.add( light );

        light = new THREE.DirectionalLight( 0xffffff );
        light.position.set( 0, 200, 100 );
        light.castShadow = true;
        light.shadow.camera.top = 180;
        light.shadow.camera.bottom = - 100;
        light.shadow.camera.left = - 120;
        light.shadow.camera.right = 120;
        scene.add( light );
    }
    
    if (0) {
        //spotLight
        spotLight = new THREE.SpotLight( 0xffffff, 1 );
        spotLight.position.set( 400, 400, 1000 );
        spotLight.angle = Math.PI / 4;
        spotLight.penumbra = 0.05;
        spotLight.decay = 2;
        spotLight.distance = 200;
        spotLight.castShadow = true;
        spotLight.shadow.mapSize.width = 1024;
        spotLight.shadow.mapSize.height = 1024;
        spotLight.shadow.camera.near = 10;
        spotLight.shadow.camera.far = 200;
        scene.add( spotLight );
    }
                
    //Load background texture
    if (back_image_url.length > 0) {
        new THREE.TextureLoader()
            .load(back_image_url , function(texture)
                {
                scene.background = texture;  
                });
    }
    // model
    modelName = model.substring(0,model.lastIndexOf("."))
    modelType = model.substring(model.lastIndexOf("."))
    // console.log(modelName);
    // console.log(modelType);
    if (modelType == '.obj') { 
        objName = modelName+'.obj'
        mtlName = modelName+'.mtl'
        // console.log(objName);
        // console.log(mtlName);
    }
    else if (modelType == '.fbx') {
        objName = modelName+'.fbx'
        // console.log(objName);
    }
    else if (modelType == '.dae') {
        objName = modelName+'.dae'
        // console.log(objName);
    }
    else if (modelType == '.stl') {
        objName = modelName+'.stl'
        // console.log(objName);
    }
    else if (modelType == '.wrl') {
        objName = modelName+'.wrl'
        // console.log(objName);
    }
    // else if (modelType == '.zip') {
    // } // end zip
    
    
    var onProgress = function ( xhr ) {
        if ( xhr.lengthComputable ) {
            var percentComplete = xhr.loaded / xhr.total * 100;
            // console.log( Math.round( percentComplete, 2 ) + '% downloaded' );
        }
    };
    
    var onError = function () { };
    //if (modelType != '.wrl') {
        THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );
    //}

    if (modelType == '.obj') {
        // model
        new THREE.MTLLoader()
            //.setPath( 'assets/ruuvitag/' )
            //.load( 'ruuvipurple2.mtl', function ( materials ) {
            .load( mtlName, function ( materials ) {
                materials.preload();
                // background image
                
                new THREE.OBJLoader()
                    .setMaterials( materials )
                    //.setPath( 'assets/ruuvitag/' )
                    //.load( 'ruuvipurple2.obj', function ( object ) {
                    .load( objName, function ( object ) {
                        // object.position.y = - 05;
                        object.rotation.set( degToRad(rx), degToRad(ry), degToRad(rz) );
                        scene.add( object );
                        //fitCameraToObject ( camera, object, 1.15, controls );
                        // object.position.set( px, py, pz );
                        fitCameraToObject ( camera, object, ioffset, controls );
                        //showhide("spinner");
                        //hide("spinner");
                        //hide('$canvas_nameSpin')
                        
                        setTimeout(function() { 
                            //jQuery('.imgpreloader').fadeIn('slow'); // hide();
                            jQuery('.imgpreloader').fadeOut('slow'); // hide();
                            if (autostart == true) {
                                rotate=true;
                            }
                        }, 100);  //ms
                    }, onProgress, onError );
            } );
    }
    else if (modelType== '.fbx') {
        // model
        // var mixer;
        var loader = new THREE.FBXLoader();
        //loader.load( 'https://threejs.org/examples/models/fbx/Samba Dancing.fbx', function ( object ) {
        loader.load( objName, function ( object ) {
            mixer = new THREE.AnimationMixer( object );
            if (object.animations.length > 0) {
                var action = mixer.clipAction( object.animations[ 0 ] );
                action.play();
            }
            object.traverse( function ( child ) {
                if ( child.isMesh ) {
                    child.castShadow = true;
                    child.receiveShadow = true;
                }
            } );
            object.rotation.set( degToRad(rx), degToRad(ry), degToRad(rz) );
            scene.add( object );
            fitCameraToObject ( camera, object, ioffset, controls );
            setTimeout(function() { 
                    //jQuery('.imgpreloader').fadeIn('slow'); // hide();
                    jQuery('.imgpreloader').fadeOut('slow'); // hide();
                    if (autostart == true) {
                        rotate=true;
                    }
                }, 100);  //ms
            }, onProgress, onError );
    }
    // else if (modelType == '.dae') {
    //     
    //     // var loadingManager = new THREE.LoadingManager( function () {
    //     //     scene.add( dae_obj );
    //     // } );
    // 
    //     // collada
    //     // var loader = new THREE.ColladaLoader();
    //     // loader.load( 'https://github.com/mrdoob/three.js/raw/master/examples/models/collada/elf/elf.dae', function ( object ) {
    //     //     //dae_obj = object.scene;
    //     //     scene.add( object );
    //     // } );
    //     //scene.add( dae_obj );
    //     
    //     // // loading manager
    //     // var loadingManager = new THREE.LoadingManager( function () {
    //  //  scene.add( dae_obj );
    //  // } );
    //     // // collada
    //     // var loader = new THREE.ColladaLoader( loadingManager );
    //     // loader.load( objName, function ( collada ) {
    //     //     dae_obj = collada.scene;
    //     // } );
    //     
    // }
    //
    if (modelType == '.stl') {
        // console.log('it doesn\'t work with CORS');
        // ASCII file
        var loader = new THREE.STLLoader();
        loader.load( objName, function ( geometry ) {
            var material = new THREE.MeshPhongMaterial( { color: mesh_color, specular: 0x111111, shininess: 200 } );
            var mesh = new THREE.Mesh( geometry, material );
        
            // mesh.position.set( 0, - 0.25, 0.6 );
            // mesh.rotation.set( 0, - Math.PI / 2, 0 );
            // mesh.scale.set( .3,.3,.3); //0.5, 0.5, 0.5 );
        
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            object = mesh;
            
            object.rotation.set( degToRad(rx), degToRad(ry), degToRad(rz) );
            scene.add( object );
            fitCameraToObject ( camera, object, ioffset, controls );
            // object.scale.set( scx,scy,scz); //0.5, 0.5, 0.5 );
        
            setTimeout(function() { 
                    //jQuery('.imgpreloader').fadeIn('slow'); // hide();
                    jQuery('.imgpreloader').fadeOut('slow'); // hide();
                    if (autostart == true) {
                        rotate=true;
                    }
                }, 100);  //ms
            }, onProgress, onError );
        //} );
        
        
        // // Binary files
        // 
        // var material = new THREE.MeshPhongMaterial( { color: 0xAAAAAA, specular: 0x111111, shininess: 200 } );
        // 
        // loader.load( './models/stl/binary/pr2_head_pan.stl', function ( geometry ) {
        // 
        //     var mesh = new THREE.Mesh( geometry, material );
        // 
        //     mesh.position.set( 0, - 0.37, - 0.6 );
        //     mesh.rotation.set( - Math.PI / 2, 0, 0 );
        //     mesh.scale.set( 2, 2, 2 );
        // 
        //     mesh.castShadow = true;
        //     mesh.receiveShadow = true;
        // 
        //     scene.add( mesh );
        // 
        // } );
        // 
        // loader.load( './models/stl/binary/pr2_head_tilt.stl', function ( geometry ) {
        // 
        //     var mesh = new THREE.Mesh( geometry, material );
        // 
        //     mesh.position.set( 0.136, - 0.37, - 0.6 );
        //     mesh.rotation.set( - Math.PI / 2, 0.3, 0 );
        //     mesh.scale.set( 2, 2, 2 );
        // 
        //     mesh.castShadow = true;
        //     mesh.receiveShadow = true;
        // 
        //     scene.add( mesh );
        // 
        // } );
        // 
        // // Colored binary STL
        // loader.load( './models/stl/binary/colored.stl', function ( geometry ) {
        // 
        //     var meshMaterial = material;
        //     if ( geometry.hasColors ) {
        // 
        //         meshMaterial = new THREE.MeshPhongMaterial( { opacity: geometry.alpha, vertexColors: THREE.VertexColors } );
        // 
        //     }
        // 
        //     var mesh = new THREE.Mesh( geometry, meshMaterial );
        // 
        //     mesh.position.set( 0.5, 0.2, 0 );
        //     mesh.rotation.set( - Math.PI / 2, Math.PI / 2, 0 );
        //     mesh.scale.set( 0.3, 0.3, 0.3 );
        // 
        //     mesh.castShadow = true;
        //     mesh.receiveShadow = true;
        // 
        //     scene.add( mesh );
        // 
        // } );
    }
    else if (modelType == '.wrl') {
        
        var loader = new THREE.VRMLLoader();
        // loader.load( 'assets/house.wrl', function ( object ) {
        
        // loader.load( objName, function ( object ) {
        //         //loader.load( 'assets/oshwi.wrl', function ( object ) {
        //             scene.add( object );
        //             //fitCameraToObject ( camera, object, 1.35, controls );
        //             console.log('Done!');
        // 
        //         } );
        // console.log('wrl loading1',objName);
        loader.load( objName, function ( object ) {
        //loader.load( 'assets/oshwi.wrl', function ( object ) {
            object.rotation.set( degToRad(rx), degToRad(ry), degToRad(rz) );
            scene.add( object );
            fitCameraToObject ( camera, object, ioffset, controls );
            //showhide("spinner");
            //hide("spinner");
            //hide('$canvas_nameSpin')
            setTimeout(function() { 
                //jQuery('.imgpreloader').fadeIn('slow'); // hide();
                jQuery('.imgpreloader').fadeOut('slow'); // hide();
                if (autostart == true) {
                    rotate=true;
                }
            }, 100);  //ms
        //} );
        }, onProgress, onError );
    }
    // renderer

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setPixelRatio( window.devicePixelRatio );
    // renderer.setSize( window.innerWidth, window.innerHeight );
    
    // //container = document.createElement( 'div' );
    // //document.body.appendChild( container );
    // //container.appendChild( renderer.domElement );
    //container = document.createElement('div');
    // //container.setAttribute("id", $canvas_nameM);
    //container.appendChild( renderer.domElement );
    // console.log( cname +' cname' );
    document.getElementById(cname).appendChild( renderer.domElement );
    controls = new THREE.OrbitControls( camera , renderer.domElement );
    divS = document.getElementById(cname);
    //renderer.setSize( divS.innerWidth, divS.innerHeight );
    // console.log( divS.clientWidth +' w '+ divS.clientWidth/ar +' h ' + ar + ' ar');
    //renderer.setPixelRatio( divS.devicePixelRatio );
    renderer.setSize( divS.clientWidth, divS.clientWidth/ar);
    //jQuery('$canvas_name').append(container);
    // stats = new Stats();
    // container.appendChild( stats.dom );

    //

    window.addEventListener( 'resize', onWindowResize, false );
    //showhide("spinner");
}

function onWindowResize() {

    //jQuery(document).ready(function($) {
        // camera.aspect = window.innerWidth / window.innerHeight;
        // camera.updateProjectionMatrix();
        //jQuery('head').append('<meta name=\'viewport\' content=\'width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0\'/>');
        divS = document.getElementById(cname);
        //renderer.setSize( divS.innerWidth, divS.innerHeight );
        // console.log( divS.clientWidth +' w '+ divS.clientWidth/ar +' h ' + ar + ' ar');
        // camera.aspect = divS.clientWidth / divS.clientHeight;
        // console.log( divS.clientWidth + ':w '+ ar +':ar');
        camera.aspect = divS.clientWidth / (divS.clientWidth / ar) ;
        camera.updateProjectionMatrix();
        renderer.setSize( divS.clientWidth-0.5, divS.clientWidth/ar);
    //});
}

function animate() {

    // for ( var i = 0; i < views.length; ++ i ) {
    //              views[ i ].render();
    //          }
    requestAnimationFrame( animate );
    //rotate = true;
    if (rotate) {
        var timer=Date.now() * 0.0005 * speed;
        //var timer=Date.now() * 0.00005;
        r=cameraZ*offs*1.0;
        //r=camera.position.z // *offs;
        camera.position.x=r*Math.cos(timer);
        camera.position.z=r*Math.sin(timer);
        camera.lookAt(scene.position);
        if (debug) {
            console.log( timer + '% t' );
            console.log( camera.position.x + '% x' );
            console.log( camera.position.z + '% z' );
        }
    }
    else {
        r=camera.position.z // *offs;
        //console.log( r + '% r' );
    }
    var delta = clock.getDelta();
    if ( mixer ) mixer.update( delta );
    
    renderer.render( scene, camera );
    // stats.update();
}
