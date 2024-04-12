function initMap() {
  // The location of NSBM Green University
  const nsbm = { lat: 6.8201287, lng: 80.0384185 };
  // The map, centered at NSBM Green University
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: nsbm,
  });
  // The marker, positioned at NSBM Green University
  const marker = new google.maps.Marker({
    position: nsbm,
    map: map,
    title: "NSBM Green University",
  });

  // Example: Adding another marker for an accommodation
  // Replace 'accommodationLocation' with the actual location
  const accommodationLocation = { lat: 6.821, lng: 80.04 };
  const accommodationMarker = new google.maps.Marker({
    position: accommodationLocation,
    map: map,
    title: "Accommodation Name",
    // icon: 'URL_TO_AN_ICON', // Optional: if you want to use a custom icon
  });

  // Add more markers as needed
}
