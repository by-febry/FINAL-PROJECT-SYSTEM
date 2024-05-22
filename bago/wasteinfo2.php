<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="wastedesign2.css">
<title>Waste Management</title>
</head>
<body>

<nav>
    <div class="div left-nav"> 
        <h2>WasteCompany</h2>
    </div>
    <div class="right-nav">
        <img src="logo.png" alt="Logo">
    </div>
</nav>

<div class="container">
    <form action="insertprocess.php" method="POST" onsubmit="return confirmSubmission()">
        <!-- Biodegradable Waste -->
        <div class="one">  
            <h4>Biodegradable Waste</h4>
            <label for="prevWasteBio">Previous Waste Generated (kg):</label><br>
            <input type="number" id="prevWasteBio" name="prevWasteBio"><br>
            
            <label for="currWasteBio">Current Waste Generated (kg):</label><br>
            <input type="number" id="currWasteBio" name="currWasteBio"><br>
            
            <label for="wasteDisposalBio">Waste Disposal (kg):</label><br>
            <input type="number" id="wasteDisposalBio" name="wasteDisposalBio"><br>
            
            
            <label for="remarksBio">Remarks:</label><br>
            <textarea id="remarksBio" name="remarksBio"></textarea><br>
        </div>
        
        <!-- Non-Biodegradable Waste -->
        <div class="two">
            <h4>Non-Biodegradable Waste</h4>
            <label for="prevWasteNonBio">Previous Waste Generated (kg):</label><br>
            <input type="number" id="prevWasteNonBio" name="prevWasteNonBio"><br>
            
            <label for="currWasteNonBio">Current Waste Generated (kg):</label><br>
            <input type="number" id="currWasteNonBio" name="currWasteNonBio"><br>
            
            <label for="wasteDisposalNonBio">Waste Disposal (kg):</label><br>
            <input type="number" id="wasteDisposalNonBio" name="wasteDisposalNonBio"><br>
            
            
            <label for="remarksNonBio">Remarks:</label><br>
            <textarea id="remarksNonBio" name="remarksNonBio"></textarea><br>
        </div>
        
        <!-- Other Waste -->
        <div class="three">
            <h4>Other Waste</h4>
            <label for="prevWasteOther">Previous Waste Generated (kg):</label><br>
            <input type="number" id="prevWasteOther" name="prevWasteOther"><br>
            
            <label for="currWasteOther">Current Waste Generated (kg):</label><br>
            <input type="number" id="currWasteOther" name="currWasteOther"><br>
            
            <label for="wasteDisposalOther">Waste Disposal (kg):</label><br>
            <input type="number" id="wasteDisposalOther" name="wasteDisposalOther"><br>
            
            
            <label for="remarksOther">Remarks:</label><br>
            <textarea id="remarksOther" name="remarksOther"></textarea><br>
        </div>
        
        <!-- Submit Button -->
        <input type="submit" value="Submit">
    </form>
</div>

<script>
function confirmSubmission() {
    var inputs = document.querySelectorAll('input[type="number"]');
    var remarks = document.getElementById('remarksBio').value.trim();
    var isEmpty = false;

    inputs.forEach(function(input) {
        if (input.value.trim() === '') {
            isEmpty = true;
            return;
        }
    });

    if (remarks === '') {
        alert("Error: Please fill in all fields.");
        return false;
    }

    var confirmed = confirm("Are you sure you want to submit this form?");
    return confirmed;
}

</script>
</body>
</html>
