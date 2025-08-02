import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
void main() {
  runApp(RobotArmApp());
}

Future<void> savePoseToServer(List<double> motors) async {
  final url = Uri.parse("http://172.20.10.6:8888/web_task3/save_pose.php");


  try {
    final response = await http.post(url, body: {
      'servo1': motors[0].toInt().toString(),
      'servo2': motors[1].toInt().toString(),
      'servo3': motors[2].toInt().toString(),
      'servo4': motors[3].toInt().toString(),
    });

    if (response.statusCode == 200) {
      print("✅ Saved: ${response.body}");
    } else {
      print("❌ Failed: ${response.statusCode}");
    }
  } catch (e) {
    print("❌ Error: $e");
  }
}


class RobotArmApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Robot Arm Control Panel',
      theme: ThemeData(
        primarySwatch: Colors.deepPurple,
      ),
      home: ControlPage(),
    );
  }
}

class ControlPage extends StatefulWidget {
  @override
  _ControlPageState createState() => _ControlPageState();
}

class _ControlPageState extends State<ControlPage> {
  List<double> motorValues = [90, 90, 90, 90];
  List<List<double>> savedPoses = [];

  void resetMotors() {
    setState(() {
      motorValues = [90, 90, 90, 90];
    });
  }

  void savePose() {
  setState(() {
    savedPoses.add(List.from(motorValues));
  });
  savePoseToServer(motorValues); 
}


  void runPose(List<double> pose) {
    setState(() {
      motorValues = List.from(pose);
    });
  }

  void deletePose(int index) {
    setState(() {
      savedPoses.removeAt(index);
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.purple.shade50,
      appBar: AppBar(
        title: Text("Robot Arm Control Panel"),
      ),
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          children: [
            for (int i = 0; i < 4; i++) ...[
              Text("Motor ${i + 1}: ${motorValues[i].toInt()}"),
              Slider(
                value: motorValues[i],
                min: 0,
                max: 180,
                onChanged: (val) {
                  setState(() {
                    motorValues[i] = val;
                  });
                },
              ),
            ],
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                ElevatedButton(onPressed: resetMotors, child: Text("Reset")),
                ElevatedButton(onPressed: savePose, child: Text("Save Pose")),
                ElevatedButton(
                    onPressed: () {
                      // هنا يمكن تشغيل آخر وضعية محفوظة
                      if (savedPoses.isNotEmpty) {
                        runPose(savedPoses.last);
                      }
                    },
                    child: Text("Run")),
              ],
            ),
            SizedBox(height: 20),
            Text("Saved Poses:", style: TextStyle(fontWeight: FontWeight.bold)),
            Expanded(
              child: ListView.builder(
                itemCount: savedPoses.length,
                itemBuilder: (context, index) {
                  final pose = savedPoses[index];
                  return Card(
                    child: ListTile(
                      title: Text("Pose ${index + 1}: ${pose.map((e) => e.toInt()).join(', ')}"),
                      leading: IconButton(
                        icon: Icon(Icons.play_arrow),
                        onPressed: () => runPose(pose),
                      ),
                      trailing: IconButton(
                        icon: Icon(Icons.delete, color: Colors.red),
                        onPressed: () => deletePose(index),
                      ),
                    ),
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
