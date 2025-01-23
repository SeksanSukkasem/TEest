// App.js
import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { createStackNavigator } from '@react-navigation/stack';
import { StatusBar } from 'react-native';
import { 
  Map, 
  Navigation as NavIcon, 
  Phone, 
  Settings,
  Home
} from 'lucide-react-native';

// Screens
import MapScreen from './screens/MapScreen';
import NavigationScreen from './screens/NavigationScreen';
import ContactScreen from './screens/ContactScreen';
import SettingsScreen from './screens/SettingsScreen';
import HomeScreen from './screens/HomeScreen';

const Tab = createBottomTabNavigator();
const Stack = createStackNavigator();

const TabNavigator = () => (
  <Tab.Navigator
    screenOptions={({ route }) => ({
      tabBarIcon: ({ color, size }) => {
        let icon;
        switch (route.name) {
          case 'หน้าแรก':
            icon = <Home size={size} color={color} />;
            break;
          case 'แผนที่':
            icon = <Map size={size} color={color} />;
            break;
          case 'นำทาง':
            icon = <NavIcon size={size} color={color} />;
            break;
          case 'ติดต่อ':
            icon = <Phone size={size} color={color} />;
            break;
          case 'ตั้งค่า':
            icon = <Settings size={size} color={color} />;
            break;
        }
        return icon;
      },
      tabBarActiveTintColor: '#3B82F6',
      tabBarInactiveTintColor: 'gray',
    })}
  >
    <Tab.Screen name="หน้าแรก" component={HomeScreen} />
    <Tab.Screen name="แผนที่" component={MapScreen} />
    <Tab.Screen name="นำทาง" component={NavigationScreen} />
    <Tab.Screen name="ติดต่อ" component={ContactScreen} />
    <Tab.Screen name="ตั้งค่า" component={SettingsScreen} />
  </Tab.Navigator>
);

const App = () => {
  return (
    <NavigationContainer>
      <StatusBar barStyle="dark-content" />
      <Stack.Navigator>
        <Stack.Screen 
          name="Main" 
          component={TabNavigator} 
          options={{ headerShown: false }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default App;

// screens/MapScreen.js
import React, { useEffect, useState } from 'react';
import { View, StyleSheet, Alert } from 'react-native';
import MapView, { Marker, Circle } from 'react-native-maps';
import * as Location from 'expo-location';

const MapScreen = () => {
  const [location, setLocation] = useState(null);
  const [elephantMarkers, setElephantMarkers] = useState([]);

  useEffect(() => {
    (async () => {
      let { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        Alert.alert('Permission denied', 'Location permission is required');
        return;
      }

      let location = await Location.getCurrentPositionAsync({});
      setLocation(location);
      fetchElephantData();
    })();
  }, []);

  const fetchElephantData = async () => {
    try {
      const response = await fetch('https://aprlabtop.com/elephant_api/get_detections.php');
      const data = await response.json();
      
      if (data.status === 'success' && Array.isArray(data.data)) {
        setElephantMarkers(data.data);
      }
    } catch (error) {
      console.error('Error fetching elephant data:', error);
    }
  };

  const initialRegion = {
    latitude: 14.439606,
    longitude: 101.372359,
    latitudeDelta: 0.0922,
    longitudeDelta: 0.0421,
  };

  const cameraLocations = [
    {
      id: 2,
      position: { latitude: 14.17069, longitude: 101.89502 },
    },
    {
      id: 3,
      position: { latitude: 14.19407, longitude: 101.89442 },
    },
  ];

  return (
    <View style={styles.container}>
      <MapView 
        style={styles.map}
        initialRegion={initialRegion}
      >
        {location && (
          <Marker
            coordinate={{
              latitude: location.coords.latitude,
              longitude: location.coords.longitude,
            }}
            title="ตำแหน่งของคุณ"
          />
        )}
        
        {elephantMarkers.map((marker, index) => (
          <Marker
            key={index}
            coordinate={{
              latitude: parseFloat(marker.lat_ele),
              longitude: parseFloat(marker.long_ele),
            }}
            title="ช้างป่าที่ตรวจพบ"
            description={new Date(marker.timestamp).toLocaleString()}
          />
        ))}

        {cameraLocations.map((camera) => (
          <React.Fragment key={camera.id}>
            <Marker
              coordinate={camera.position}
              title={`กล้อง CCTV #${camera.id}`}
            />
            <Circle
              center={camera.position}
              radius={1000}
              fillColor="rgba(255, 92, 92, 0.2)"
              strokeColor="#FF5C5C"
              strokeWidth={2}
            />
            <Circle
              center={camera.position}
              radius={500}
              fillColor="rgba(255, 0, 0, 0.1)"
              strokeColor="#FF0000"
              strokeWidth={2}
            />
          </React.Fragment>
        ))}
      </MapView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  map: {
    flex: 1,
  },
});

export default MapScreen;

// screens/NavigationScreen.js
import React, { useState } from 'react';
import { View, TextInput, Button, StyleSheet } from 'react-native';

const NavigationScreen = () => {
  const [startLocation, setStartLocation] = useState('');
  const [endLocation, setEndLocation] = useState('');

  const handleCreateRoute = () => {
    // Implement route creation logic
  };

  return (
    <View style={styles.container}>
      <TextInput
        style={styles.input}
        placeholder="กรอกชื่อสถานที่เริ่มต้น"
        value={startLocation}
        onChangeText={setStartLocation}
      />
      <TextInput
        style={styles.input}
        placeholder="กรอกชื่อสถานที่ปลายทาง"
        value={endLocation}
        onChangeText={setEndLocation}
      />
      <Button title="สร้างเส้นทาง" onPress={handleCreateRoute} />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 8,
    padding: 12,
    marginBottom: 16,
  },
});

export default NavigationScreen;

// screens/ContactScreen.js
import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity, Linking } from 'react-native';
import { Phone } from 'lucide-react-native';

const ContactScreen = () => {
  const handleCall = () => {
    Linking.openURL('tel:0970533906');
  };

  return (
    <View style={styles.container}>
      <TouchableOpacity style={styles.callButton} onPress={handleCall}>
        <Phone size={24} color="white" />
        <Text style={styles.buttonText}>ติดต่อเจ้าหน้าที่</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 16,
  },
  callButton: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#3B82F6',
    padding: 16,
    borderRadius: 8,
    gap: 8,
  },
  buttonText: {
    color: 'white',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default ContactScreen;

// screens/SettingsScreen.js
import React, { useState } from 'react';
import { View, Text, Switch, StyleSheet } from 'react-native';

const SettingsScreen = () => {
  const [isDarkMode, setIsDarkMode] = useState(false);
  const [notifications, setNotifications] = useState(true);

  return (
    <View style={styles.container}>
      <View style={styles.setting}>
        <Text>โหมดกลางคืน</Text>
        <Switch value={isDarkMode} onValueChange={setIsDarkMode} />
      </View>
      <View style={styles.setting}>
        <Text>การแจ้งเตือน</Text>
        <Switch value={notifications} onValueChange={setNotifications} />
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
  },
  setting: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: '#eee',
  },
});

export default SettingsScreen;