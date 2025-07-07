<?php
// kenya-counties-map.php
$title = "Interactive Kenya Counties Map";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        .county {
            fill: #4CAF50;
            stroke: #fff;
            stroke-width: 1px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .county:hover {
            fill: #FF5722;
            transform: translateY(-2px);
            filter: drop-shadow(0 0 5px rgba(0,0,0,0.3));
        }
        .county-tooltip {
            position: absolute;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            pointer-events: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 100;
        }
        #map-container {
            position: relative;
            max-width: 800px;
            margin: 20px auto;
        }
        h1 {
            text-align: center;
            color: #333;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($title); ?></h1>
    <div id="map-container">
        <div class="county-tooltip" id="county-tooltip"></div>
        <?php
        // SVG Map of Kenya with Counties
        echo <<<SVG
        <svg version="1.1" id="kenya-map" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 800 900" style="enable-background:new 0 0 800 900;" xml:space="preserve">
            
            <!-- Nairobi -->
            <path id="nairobi" class="county" d="M400,200 L410,210 L420,205 L415,195 Z" data-county="Nairobi"/>
            
            <!-- Mombasa -->
            <path id="mombasa" class="county" d="M500,500 L510,510 L520,505 L515,495 Z" data-county="Mombasa"/>
            
            <!-- Kisumu -->
            <path id="kisumu" class="county" d="M300,400 L310,410 L320,405 L315,395 Z" data-county="Kisumu"/>
            
            <!-- Nakuru -->
            <path id="nakuru" class="county" d="M350,300 L360,310 L370,305 L365,295 Z" data-county="Nakuru"/>
            
            <!-- Eldoret -->
            <path id="eldoret" class="county" d="M280,280 L290,290 L300,285 L295,275 Z" data-county="Uasin Gishu"/>
            
            <!-- Note: This is a simplified SVG with sample paths. 
                 For a complete map, you would need the actual SVG paths for all 47 counties -->
        </svg>
SVG;
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counties = document.querySelectorAll('.county');
            const tooltip = document.getElementById('county-tooltip');
            
            counties.forEach(county => {
                county.addEventListener('mouseenter', function() {
                    // Highlight county
                    this.style.fill = '#FF5722';
                    this.style.transform = 'scale(1.02)';
                    
                    // Show tooltip
                    const countyName = this.getAttribute('data-county');
                    tooltip.textContent = countyName;
                    tooltip.style.opacity = '1';
                    
                    // Position tooltip near cursor
                    const rect = this.getBoundingClientRect();
                    tooltip.style.left = `${rect.left + window.scrollX}px`;
                    tooltip.style.top = `${rect.top + window.scrollY - 40}px`;
                });
                
                county.addEventListener('mouseleave', function() {
                    // Reset county appearance
                    this.style.fill = '#4CAF50';
                    this.style.transform = '';
                    
                    // Hide tooltip
                    tooltip.style.opacity = '0';
                });
                
                county.addEventListener('mousemove', function(e) {
                    // Move tooltip with cursor
                    tooltip.style.left = `${e.pageX + 10}px`;
                    tooltip.style.top = `${e.pageY - 20}px`;
                });
            });
        });
    </script>
</body>
</html>