import { GoogleMap, LoadScript, Marker } from '@react-google-maps/api';
const { memo, useState, useEffect } = wp.element;

const MapControl = ({value, onChange}) => {

  const containerStyle = {
    width: '400px',
    height: '400px'
  };
  
  const initialCenter = value ? value : {
    lat: -3.745,
    lng: -38.523
  };

  const [ center, setCenter ] = useState(initialCenter)
  const [ location, setLocation ] = useState(value ? value : null)

  useEffect(() => {
    onChange && onChange(location)
  }, [location])

  return (
    <LoadScript
      googleMapsApiKey="AIzaSyB6iyv7fOYWfGy7l6VszXXbNUy1y8pgXqE"
    >
      <GoogleMap
        mapContainerStyle={containerStyle}
        center={center}

        onClick={(e) => setLocation(e.latLng.toJSON())}
        zoom={10}
      >
        { location && (
          <Marker position={location} />
        )}
      </GoogleMap>
    </LoadScript>
  )
}

export default memo(MapControl)
