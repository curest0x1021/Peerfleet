var geoData = {
  type: "FeatureCollection",
  features: [
    {
      type: "Feature",
      id: "west-mediterranean-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-5.51788330078125, 36.1334383124587],
            [-5.38330078125, 35.536696378395],
            [-5.4931640625, 34.4159733844819],
            [14.94140625, 31.952162238025],
            [16.787109375, 39.3002991861503],
            [14.853515625, 41.5414776667903],
            [10.2392578125, 45.5525252513401],
            [9.7998046875, 49.0666683955812],
            [-5.51788330078125, 36.1334383124587],
          ],
        ],
      },
      properties: { name: "West Mediterranean Sea" },
    },
    {
      type: "Feature",
      id: "east-mediterranean-black-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [15.0732, 31.9894],
            [16.7871, 39.4022],
            [10.3271, 45.6755],
            [10.2393, 49.0955],
            [16.4795, 50.8476],
            [46.494140625, 46.1341700462433],
            [39.2871, 38.4794],
            [34.7168, 30.9022],
            [30.2783, 30.789],
            [22.2803, 31.1282],
            [19.1162, 29.0754],
            [15.0732, 31.9894],
          ],
        ],
      },
      properties: { name: "East Mediterranean Sea & Black Sea" },
    },
    {
      type: "Feature",
      id: "indian-ocean",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [53.0419921875, 5.2660078828055],
            [69.1259765625, 5.35352135533733],
            [68.6426, 13.0688],
            [70.6641, 17.4764],
            [64.6875, 23.8858],
            [66.0938, 28.1495],
            [97.4707, 22.9989],
            [99.3164, 11.6953],
            [99.1406, 9.1889],
            [100.0195, 7.1881],
            [102.5684, 4.3026],
            [102.5684, -4.3026],
            [102.9199, -37.9962],
            [101.3379, -51.3992],
            [58.623, -51.5087],
            [66.5332, -16.8045],
            [53.0419921875, 5.2660078828055],
          ],
        ],
      },
      properties: { name: "Indian Ocean" },
    },
    {
      type: "Feature",
      id: "australia-oceania",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [111.97265625, -12.211180191504],
            [103.359375, -15.4536802243458],
            [102.48046875, -51.1793429792893],
            [152.40234375, -55.9491998233674],
            [198.45703125, -49.2678045506375],
            [175.78125, -27.7224359189734],
            [168.046875, -18.3545255291266],
            [162.861328125, -10.0121295579081],
            [153.6328125, 1.40610883543516],
            [136.93359375, -4.39022892646338],
            [111.97265625, -12.211180191504],
          ],
        ],
      },
      properties: { name: "Australia / Oceania" },
    },
    {
      type: "Feature",
      id: "south-east-asia-china-vietnam",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [104.58984375, 23.8054496123146],
            [104.23828125, 16.2146745882485],
            [105.556640625, 10.4878118820567],
            [118.4765625, 16.0458134537522],
            [131.484375, 24.5271348225978],
            [129.111328125, 28.7676591056912],
            [124.365234375, 34.5246614717717],
            [126.5625, 38.6168704639297],
            [122.607421875, 44.964797930331],
            [111.357421875, 42.0329743324414],
            [104.765625, 31.0529339857052],
            [104.58984375, 23.8054496123146],
          ],
        ],
      },
      properties: { name: "South East Asia (China, Vietnam)" },
    },
    {
      type: "Feature",
      id: "north-asia-japan-korea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [126.5625, 38.341656192796],
            [124.4091796875, 34.5246614717717],
            [129.1552734375, 28.8061735088548],
            [132.71484375, 24.0464639996666],
            [139.5703125, 27.6835280837878],
            [144.140625, 29.5352295629485],
            [149.9853515625, 44.7155137320213],
            [152.05078125, 48.0780789434986],
            [140.712890625, 47.0701218238331],
            [127.6611328125, 42.7470121731807],
            [126.5625, 38.341656192796],
          ],
        ],
      },
      properties: { name: "North Asia (Japan, Korea)" },
    },
    {
      type: "Feature",
      id: "south-asia",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [103.88671875, 6.14055478245031],
            [102.12890625, 11.1784018737118],
            [99.624, 14.1366],
            [91.0546875, 23.5639871284512],
            [92.63671875, 17.8114560885645],
            [92.4609375, 12.5545635285937],
            [100.7666, 6.5336],
            [93.515625, 7.53676432208408],
            [96.15234375, -2.63578857416661],
            [99.140625, -7.36246686553574],
            [103.0078, -15.623],
            [126.9140625, -11.1784018737118],
            [134.82421875, 18.9790259532553],
            [121.2891, 18.8127],
            [103.88671875, 6.14055478245031],
          ],
        ],
      },
      properties: { name: "South Asia" },
    },
    {
      type: "Feature",
      id: "west-africa",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-5.5289, 35.9669],
            [-24.3457, 35.6037],
            [-42.8906, 33.8704],
            [-9.84375, -19.642587534013],
            [-3.515625, -19.642587534013],
            [1.0546875, -18.9790259532553],
            [23.5546875, -17.9787330955562],
            [17.0508, 20.7972],
            [-5.5289, 35.9669],
          ],
        ],
      },
      properties: { name: "West Africa" },
    },
    {
      type: "Feature",
      id: "east-africa",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [21.2695, 8.9285],
            [47.8125, 7.8851],
            [66.6211, -17.4764],
            [52.20703125, -17.6440220278727],
            [29.1796875, -16.1302620120347],
            [23.73046875, -15.9613290815966],
            [22.67578125, -5.61598581915533],
            [21.2695, 8.9285],
          ],
        ],
      },
      properties: { name: "East Africa" },
    },
    {
      type: "Feature",
      id: "north-america-west-coast",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-156.62109375, 67.941650035336],
            [-153.984375, 58.9953111879509],
            [-154.3359375, 50.4015153227824],
            [-148.18359375, 48.9224992637583],
            [-99.66796875, 11.3507967223837],
            [-93.1640625, 16.972741019999],
            [-99.8437500000001, 23.885837699862],
            [-118.125, 48.3416461723746],
            [-122.6953125, 61.68987220046],
            [-134.12109375, 68.3991800434419],
            [-149.0625, 66.5132604431118],
            [-156.62109375, 67.941650035336],
          ],
        ],
      },
      properties: { name: "North America West Coast" },
    },
    {
      type: "Feature",
      id: "north-america-east-coast",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-45, 66.2315],
            [-95.2734, 66.3728],
            [-96.1523, 57.8915],
            [-75.40444830481363, 51.60721941725819],
            [-65.97291042299737, 47.138770735449874],
            [-82.4414, 29.5352],
            [-40.2539, 30.297],
            [-43.9453, 34.0162],
            [-44.1211, 60.2398],
            [-45, 66.2315],
          ],
        ],
      },
      properties: { name: "North America East Coast" },
    },
    {
      type: "Feature",
      id: "great-lakes",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-89.371201, 49.944813],
            [-93.216662, 47.182946],
            [-92.117959, 43.954024],
            [-86.184962, 40.539634],
            [-79.153261, 41.534025],
            [-72.780783, 44.583376],
            [-66.298434, 47.997963],
            [-74.209097, 51.475182],
            [-89.371201, 49.944813],
          ],
        ],
      },
      properties: { name: "Great Lakes" },
    },
    {
      type: "Feature",
      id: "us-gulf",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-79.1015625, 29.6880527498568],
            [-80.771484375, 23.8054496123146],
            [-81.298828125, 22.7559206814864],
            [-87.978515625, 20.9614396140968],
            [-91.845703125, 16.8886597873816],
            [-98.4375, 17.8114560885645],
            [-102.041015625, 25.5622650144275],
            [-97.294921875, 32.9164853473144],
            [-83.935546875, 32.1756124784993],
            [-82.353515625, 28.9985318140518],
            [-79.1015625, 29.6880527498568],
          ],
        ],
      },
      properties: { name: "US Gulf" },
    },
    {
      type: "Feature",
      id: "caribbean-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-78.92578125, 29.3821750751453],
            [-46.2304687500001, 30.221101852486],
            [-63.28125, 9.53574899813363],
            [-75.234375, 7.53676432208408],
            [-79.27734375, 9.0153023334206],
            [-84.0234375, 9.79567758282974],
            [-84.90234375, 13.2399454992863],
            [-89.560546875, 16.1302620120348],
            [-89.560546875, 18.6462451426706],
            [-88.06640625, 21.2074587304826],
            [-81.03515625, 22.8369459209439],
            [-78.92578125, 29.3821750751453],
          ],
        ],
      },
      properties: { name: "Caribbean Sea" },
    },
    {
      type: "Feature",
      id: "south-america-east-coast",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-45.703125, 29.8406438998344],
            [-66.4453125, 5.61598581915534],
            [-57.65625, -29.5352295629484],
            [-68.5546875, -38.8225909761771],
            [-71.1474609375001, -55.2916284868299],
            [-67.60986328125, -56.1455495006791],
            [-31.6955566406251, -55.0217245215306],
            [4.921875, -52.4827802220782],
            [-1.75781250000006, -32.5468131735151],
            [-41.484375, 29.8406438998344],
            [-45.703125, 29.8406438998344],
          ],
        ],
      },
      properties: { name: "South America East Coast" },
    },
    {
      type: "Feature",
      id: "bering-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [132.1875, 59.8006342610287],
            [139.39453125, 49.951219908662],
            [140.2734375, 47.5172006978394],
            [204.08203125, 51.2894059027168],
            [201.62109375, 66.0893642704709],
            [130.60546875, 65.5857200232947],
            [132.1875, 59.8006342610287],
          ],
        ],
      },
      properties: { name: "Bering Sea" },
    },
    {
      type: "Feature",
      id: "red-sea-persian-gulf",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [35.68359375, 11.7813252961123],
            [29.794921875, 30.8267809047798],
            [51.7676, 31.9522],
            [56.6016, 26.5197],
            [63.193359375, 26.6670958011048],
            [67.060546875, 18.2293513383867],
            [55.107421875, 8.75479470243562],
            [35.68359375, 11.7813252961123],
          ],
        ],
      },
      properties: { name: "Red Sea & Persian Gulf" },
    },
    {
      type: "Feature",
      id: "north-sea-atlantic",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [10.1953125, 53.4455353062006],
            [8.173828125, 51.9442648790288],
            [2.5488, 46.9803],
            [-5.3531, 35.9891],
            [-42.8027, 35.1379],
            [-43.8574, 66.6356],
            [14.6337890625, 66.6529774005528],
            [11.77734375, 63.5876752947032],
            [11.1181640625, 59.4897260355371],
            [10.546875, 57.8213550354294],
            [10.426025390625, 57.6924055352645],
            [9.0966796875, 56.2555574519306],
            [9.3658447265625, 54.7579160793699],
            [9.51278686523438, 54.4883888458276],
            [9.86434936523438, 54.2908816465701],
            [10.1953125, 53.4455353062006],
          ],
        ],
      },
      properties: { name: "North Sea / Atlantic" },
    },
    {
      type: "Feature",
      id: "south-america-west-coast",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-94.306640625, 17.30868788677],
            [-97.8662109375, 14.6898813666188],
            [-100.8984375, 11.609193407939],
            [-84.462890625, -25.3241665257384],
            [-75.234375, -59.977005492196],
            [-65.7421875, -56.4139013760068],
            [-70.224609375, -52.855864177854],
            [-69.697265625, -39.5040407055841],
            [-64.51171875, -10.0554027365642],
            [-76.5527343750001, 6.83916962634281],
            [-78.662109375, 8.97189729408301],
            [-81.2548828125, 8.40716816360108],
            [-84.2871093750001, 10.0121295579082],
            [-84.90234375, 12.597454504832],
            [-87.6708984375, 13.9660540813183],
            [-92.0214843750001, 16.2568673306234],
            [-94.306640625, 17.30868788677],
          ],
        ],
      },
      properties: { name: "South America West Coast" },
    },
    {
      type: "Feature",
      id: "baltic-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [18.8086, 66.1605],
            [10.8545, 59.4171],
            [10.6128, 57.7511],
            [10.2942, 57.5335],
            [9.4922, 56.2556],
            [9.3604, 55.482],
            [9.3384, 54.8482],
            [9.4922, 54.5083],
            [10.481, 52.9619],
            [14.8535, 51.3992],
            [36.123, 53.7487],
            [40.078125, 62.8551455377418],
            [31.0254, 65.2199],
            [18.8086, 66.1605],
          ],
        ],
      },
      properties: { name: "Baltic Sea" },
    },
    {
      type: "Feature",
      id: "caspian-sea",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [51.9094844162464, 48.3513830637493],
            [54.4583125412464, 46.2355873019705],
            [51.7776484787464, 44.2556929207053],
            [55.7766719162464, 37.730178114965],
            [52.8762812912464, 35.651346418144],
            [47.7786250412464, 37.2769682920165],
            [45.8010859787464, 45.8390066613977],
            [51.9094844162464, 48.3513830637493],
          ],
        ],
      },
      properties: { name: "Caspian Sea" },
    },
    {
      type: "Feature",
      id: "south-africa",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-7.3828125, -16.972741019999],
            [62.40234375, -17.8114560885645],
            [62.40234375, -48.1074311884804],
            [-7.03125, -47.6357835908648],
            [-7.3828125, -16.972741019999],
          ],
        ],
      },
      properties: { name: "South Africa" },
    },
    {
      type: "Feature",
      id: "north-pacific",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-202.1484375, 49.1529696561704],
            [-213.75, 48.2246726495652],
            [-206.015625, 48.4583518828087],
            [-216.9140625, 29.2288900301942],
            [-206.71875, -1.40610883543516],
            [-101.25, 12.8974891837559],
            [-148.0078125, 48.9224992637583],
            [-168.75, 51.3992056535538],
            [-202.1484375, 49.1529696561704],
          ],
        ],
      },
      properties: { name: "North Pacific" },
    },
    {
      type: "Feature",
      id: "south-pacific-ocean",
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [-204.609375, -1.75753681130831],
            [-183.8672, -28.1495],
            [-159.6094, -49.838],
            [-149.7656, -59.7121],
            [-75.9375, -59.8889],
            [-85.7813, -21.6166],
            [-101.6016, 12.5546],
            [-204.609375, -1.75753681130831],
          ],
        ],
      },
      properties: { name: "South Pacific Ocean" },
    },
  ],
};
