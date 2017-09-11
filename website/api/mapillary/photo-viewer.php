<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <title></title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    
    <script src='https://unpkg.com/mapillary-js@2.8.0/dist/mapillary.min.js'></script>
    <link href='https://unpkg.com/mapillary-js@2.8.0/dist/mapillary.min.css' rel='stylesheet' />
  
    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        #mly { height: 100%; }
    </style>
</head>

<body>
    <div id='mly'></div>

    <script>
        var componentOptions = null;

        if (Mapillary.isSupported()) {
            // Enable or disable any components, e.g. tag and popup which requires WebGL support
            // or use the default components by not supplying any component options.
            componentOptions = { /* Default options */ };
            
        } else if (Mapillary.isFallbackSupported()) {
            
            // On top of the disabled components below, also the popup, marker and tag
            // components require WebGL support and should not be enabled (they are
            // disabled by default so does not need to be specified below).
            componentOptions = {
                // Disable components requiring WebGL support
                direction: false,
                imagePlane: false,
                keyboard: false,
                mouse: false,
                sequence: false,

                // Enable fallback components
                image: true,
                navigation: true,
            }
        }
        
        componentOptions = { /* Default options */ };
        
        if (componentOptions === null) {
            
            // Handle the fact that MapillaryJS is not supported in a way that is
            // appropriate for your application.
            var messageDiv = document.createElement('div');
            messageDiv.innerHTML = "MapillaryJS is not supported by your browser.";
            messageDiv.style.marginTop = "100px";

            var mlyDiv = document.getElementById('mly');
            mlyDiv.style.textAlign = "center";
            mlyDiv.appendChild(messageDiv);
            
        } else {
            // Deactivate cover without interaction needed.
            componentOptions.cover = false;

            var mly = new Mapillary.Viewer(
                'mly',
                'LXJVNHlDOGdMSVgxZG5mVzlHQ3ZqQTo0NjE5OWRiN2EzNTFkNDg4',
                <?php echo '"'.$_GET['photo_id'].'"' ?>,
                { component: componentOptions });

            // Viewer size is dynamic so resize should be called every time the window size changes
            window.addEventListener("resize", function() { mly.resize(); });
            
            mly.on(
                Mapillary.Viewer.nodechanged, 
                function(node) {
                    if (node.latLon) {
                        Android.onNodeChanged(node.originalLatLon.lat, node.originalLatLon.lon, node.ca, node.key);
                    } else {
                        Android.onNodeChanged(NaN, NaN, NaN, '');
                    }
                });
        }
        
    </script>
</body>
</html>
