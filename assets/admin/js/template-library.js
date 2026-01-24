"use strict";

function _typeof(o) {
  "@babel/helpers - typeof";
  return (
    (_typeof =
      "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
        ? function (o) {
            return typeof o;
          }
        : function (o) {
            return o &&
              "function" == typeof Symbol &&
              o.constructor === Symbol &&
              o !== Symbol.prototype
              ? "symbol"
              : typeof o;
          }),
    _typeof(o)
  );
}
(function ($, elementor, zyre) {
  var ZyreLibrary = {
    Views: {},
    Models: {},
    Collections: {},
    Behaviors: {},
    Layout: null,
    Manager: null,
    Icon3d:
      "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgODMuNDIgNjYuOTkiPjxkZWZzPjxzdHlsZT4uY2xzLTF7aXNvbGF0aW9uOmlzb2xhdGU7fS5jbHMtMTMsLmNscy0yLC5jbHMtMjR7bWl4LWJsZW5kLW1vZGU6bXVsdGlwbHk7fS5jbHMtMntvcGFjaXR5OjAuNDt9LmNscy0ze2ZpbGw6I2I3NWUxNTt9LmNscy00e2ZpbGw6IzgxM2IxNTt9LmNscy01e2ZpbGw6IzQyMDAwMDt9LmNscy02e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQpO30uY2xzLTd7ZmlsbDp1cmwoI3JhZGlhbC1ncmFkaWVudC0yKTt9LmNscy04e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMyk7fS5jbHMtOXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTQpO30uY2xzLTEwe2ZpbGw6Izg0MmYwZjt9LmNscy0xMXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTUpO30uY2xzLTEye2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtNik7fS5jbHMtMTMsLmNscy0yNHtvcGFjaXR5OjAuNDU7fS5jbHMtMTN7ZmlsbDp1cmwoI2xpbmVhci1ncmFkaWVudCk7fS5jbHMtMTR7ZmlsbDp1cmwoI3JhZGlhbC1ncmFkaWVudC03KTt9LmNscy0xNXtmaWxsOnVybCgjcmFkaWFsLWdyYWRpZW50LTgpO30uY2xzLTE2e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtOSk7fS5jbHMtMTd7ZmlsbDojZjViNDAwO30uY2xzLTE4e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTApO30uY2xzLTE5e2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTEpO30uY2xzLTIwe2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTIpO30uY2xzLTIxe2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTMpO30uY2xzLTIye2ZpbGw6dXJsKCNyYWRpYWwtZ3JhZGllbnQtMTQpO30uY2xzLTIze2ZpbGw6I2NjNmQxNTt9LmNscy0yNHtmaWxsOiNiNzRhMDA7fTwvc3R5bGU+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQiIGN4PSIwLjYzIiBjeT0iMjUuMDEiIHI9IjM2LjY2IiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZTk5NzAwIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjY2M2ZDE1Ii8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC0yIiBjeD0iMzUuNjIiIGN5PSI1MC4xOSIgcj0iMjYuNjQiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2VmOWUwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2RkOGEyNSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtMyIgY3g9IjgwLjMyIiBjeT0iMjEuMjQiIHI9IjI0LjgiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2I5NTExOCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2E2NDEzMSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtNCIgY3g9IjM0LjQ3IiBjeT0iMy40NSIgcj0iNi4wMSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjYzg1ZDE4Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjOTY0MzI4Ii8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC01IiBjeD0iMC42MyIgY3k9IjI1LjAxIiByPSIzNi42NiIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2Y0YTUwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2QzN2YwMCIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtNiIgY3g9IjgwLjkiIGN5PSI3LjMxIiByPSIzNi41OSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZDU3MTE1Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjYjA1NzE4Ii8+PC9yYWRpYWxHcmFkaWVudD48bGluZWFyR3JhZGllbnQgaWQ9ImxpbmVhci1ncmFkaWVudCIgeDE9IjU3Ljc2IiB5MT0iMjkuNDEiIHgyPSI2NS43NSIgeTI9IjEzLjY4IiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwLjQ2IiBzdG9wLWNvbG9yPSIjNjYzNTAwIi8+PHN0b3Agb2Zmc2V0PSIwLjQ3IiBzdG9wLWNvbG9yPSIjNzQzYjAwIiBzdG9wLW9wYWNpdHk9IjAuOSIvPjxzdG9wIG9mZnNldD0iMC41NCIgc3RvcC1jb2xvcj0iI2QxNjAwMSIgc3RvcC1vcGFjaXR5PSIwLjI1Ii8+PHN0b3Agb2Zmc2V0PSIwLjU3IiBzdG9wLWNvbG9yPSIjZjU2ZTAyIiBzdG9wLW9wYWNpdHk9IjAiLz48L2xpbmVhckdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTciIGN4PSIzNS4zMiIgY3k9IjMyLjIyIiByPSIzMC4zMyIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgxLjIzIDAuNzQpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZjZiMTAwIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZWY5ZTAwIi8+PC9yYWRpYWxHcmFkaWVudD48cmFkaWFsR3JhZGllbnQgaWQ9InJhZGlhbC1ncmFkaWVudC04IiBjeD0iNDUuODciIGN5PSIxMy44MSIgcj0iNDguNDUiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2ZmZTAwMCIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2Y1YmIwMiIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtOSIgY3g9IjE4MDAuOTkiIGN5PSIxMDY4IiByPSIxNi4yOSIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNmZmY1NzgiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmNWI1MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEwIiBjeD0iMzUuMzQiIGN5PSI0MC44OSIgcj0iMTcuODYiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoMS4yMyAwLjc0KSIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPjxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2ZmY2QzYSIvPjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iI2VjYTYxNSIvPjwvcmFkaWFsR3JhZGllbnQ+PHJhZGlhbEdyYWRpZW50IGlkPSJyYWRpYWwtZ3JhZGllbnQtMTEiIGN4PSIxNzYyLjA4IiBjeT0iMTA3OS43NSIgcj0iOC4wNCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiM5YTRkMDAiLz48c3RvcCBvZmZzZXQ9IjAuNjEiIHN0b3AtY29sb3I9IiNhNDU3MDAiLz48c3RvcCBvZmZzZXQ9IjAuODEiIHN0b3AtY29sb3I9IiNhZTVlMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNiZDY4MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEyIiBjeD0iMTc5OS44NiIgY3k9IjEwOTAuOCIgcj0iOS43NCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiNjMzVmMTYiLz48c3RvcCBvZmZzZXQ9IjAuNTIiIHN0b3AtY29sb3I9IiNkMjc0MDAiLz48c3RvcCBvZmZzZXQ9IjAuNzEiIHN0b3AtY29sb3I9IiNkYTdlMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNlZDk4MDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTEzIiBjeD0iMTgwOS4zNyIgY3k9IjEwNzYuNjIiIHI9IjguNCIgZ3JhZGllbnRUcmFuc2Zvcm09InRyYW5zbGF0ZSgtMzAwNS4zNyAtMTgxMS4yNykgc2NhbGUoMS43MSkiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj48c3RvcCBvZmZzZXQ9IjAiIHN0b3AtY29sb3I9IiM3OTI2MDAiLz48c3RvcCBvZmZzZXQ9IjAuNjEiIHN0b3AtY29sb3I9IiM3ZjNhMDAiLz48c3RvcCBvZmZzZXQ9IjAuNzUiIHN0b3AtY29sb3I9IiM4OTNmMDAiLz48c3RvcCBvZmZzZXQ9IjAuOTgiIHN0b3AtY29sb3I9IiNhNTRkMDAiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNhODRlMDAiLz48L3JhZGlhbEdyYWRpZW50PjxyYWRpYWxHcmFkaWVudCBpZD0icmFkaWFsLWdyYWRpZW50LTE0IiBjeD0iMTc4Mi43MSIgY3k9IjEwODEuMDIiIHI9IjIwLjYiIGdyYWRpZW50VHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMDUuMzcgLTE4MTEuMjcpIHNjYWxlKDEuNzEpIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZmZmNTc4Ii8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjZmZjNjJjIi8+PC9yYWRpYWxHcmFkaWVudD48L2RlZnM+PGcgY2xhc3M9ImNscy0xIj48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iV29ya3MiPjxnIGNsYXNzPSJjbHMtMiI+PHBvbHlnb24gcG9pbnRzPSI4Mi42NiAxNS43OSA0MC43MiAyNi4zOCA1Ni4yNiAzNi41MiAzNi41NiA0MC4xOSAzNi41NiA0MC4wNCAwLjU3IDIxLjk1IDEuNzQgNDIuOTggMzYuOTggNjYuOTkgMzYuOTggNjYuOTcgNjUuMTkgNTkuNjMgNjUuNzMgMzUuNzkgODEuMjUgMzEuMTQgODIuNjYgMTUuNzkiLz48L2c+PHBvbHlnb24gY2xhc3M9ImNscy0zIiBwb2ludHM9IjY1Ljc1IDM0LjE2IDM2LjU2IDM5LjYgMzYuOTggNjYuMzggNjUuMTkgNTkuMDMgNjUuNzUgMzQuMTYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTQiIHBvaW50cz0iMzYuNTYgMzkuNDQgMC41NyAyMS4zNiAxLjc0IDQyLjM5IDM2Ljk4IDY2LjQgMzYuNTYgMzkuNDQiLz48cG9seWdvbiBjbGFzcz0iY2xzLTUiIHBvaW50cz0iNDAuNzIgMjUuNzkgNTguNDggMzcuMzcgODEuMjUgMzAuNTQgODIuNjYgMTUuMiA0MC43MiAyNS43OSIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtNiIgcG9pbnRzPSIzNi41NiAzOC43NyAwLjU3IDIwLjY5IDEuNzQgNDEuNzIgMzYuOTggNjUuNzMgMzYuNTYgMzguNzciLz48cG9seWdvbiBjbGFzcz0iY2xzLTciIHBvaW50cz0iNjUuNzUgMzMuNTEgMzYuNTYgMzguOTUgMzYuOTggNjUuNzMgNjUuMTkgNTguMzkgNjUuNzUgMzMuNTEiLz48cG9seWdvbiBjbGFzcz0iY2xzLTgiIHBvaW50cz0iNDAuNzIgMjQuOTYgNTguNTEgMzYuNTcgODEuMzIgMjkuNzMgODIuNzMgMTQuMzUgNDAuNzIgMjQuOTYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTkiIHBvaW50cz0iMzIuMDcgMy4yOCAzMy42IDkuNjUgMzcuNjMgMTEuMyA0NS44OSA3LjUxIDMyLjA3IDMuMjgiLz48cG9seWdvbiBjbGFzcz0iY2xzLTEwIiBwb2ludHM9IjMyLjEyIDMuMjcgMzMuODEgOS42MSAzMy40IDkuNzEgMzIuMDEgMy4zIDMyLjEyIDMuMjcgMzIuMTIgMy4yNyIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMTEiIHBvaW50cz0iMzYuNDcgMzMuMDYgMzYuNzkgNTMuODIgMS4wNiAyOS40OCAwLjA4IDExLjggMzYuNDcgMzMuMDYiLz48cG9seWdvbiBjbGFzcz0iY2xzLTEyIiBwb2ludHM9IjQwLjMzIDE2LjM2IDUyLjcgMjkuMjggODIuMTUgMjAuNDQgODMuMzYgNy43OCA4Mi45MSA3Ljg0IDQwLjMzIDE2LjM2Ii8+PHBvbHlnb24gY2xhc3M9ImNscy0xMyIgcG9pbnRzPSI4Mi43MyAxNC4zNSA4My4zNiA3Ljc4IDgyLjU0IDcuOTEgNDAuMzMgMTYuMzYgNDcuMDMgMjMuMzYgNDAuNzIgMjQuOTYgNDEuNjMgMjUuNTUgNDAuNzIgMjUuNzkgNTguNDggMzcuMzcgODEuMjUgMzAuNTQgODIuNjYgMTUuMiA4Mi42NSAxNS4yIDgyLjczIDE0LjM1IDgyLjczIDE0LjM1Ii8+PHBvbHlnb24gY2xhc3M9ImNscy0xNCIgcG9pbnRzPSI2NS40NiA0Ni4zNiAzNi43OSA1My44MiAzNi40NyAzMy4wNiA2NS44NyAyNy44NiA2NS40NiA0Ni4zNiIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMTUiIHBvaW50cz0iNDAuMzMgMTYuMzYgODMuMzEgNy43OCA4My4zNiA3Ljc0IDUzLjk5IDAuMjEgMzIuMDcgMy4yOCA0NS44OSA3LjUxIDAuMDggMTEuOCAzNi40NyAzMy4wNiA2NS44NyAyNy44NiA0MC4zMyAxNi4zNiIvPjxwYXRoIGNsYXNzPSJjbHMtMTYiIGQ9Ik04My4zNyw3Ljc4Yy4yLS4yNy00My42LDguNDUtNDMuNjIsOC4zN2EuMjEuMjEsMCwwLDAsMCwuNEw2NS44NiwyNy45Yy4yNy0uMS0yMS4xMi05LjcxLTI0Ljg4LTExLjQ2WiIvPjxwYXRoIGNsYXNzPSJjbHMtMTciIGQ9Ik00Ni44OCw3LjMxLDMyLjA4LDMuMjRjLS4yNy4xMyw5LjcsMy4xNywxMi44Miw0LjE2QzM4LjMxLDguMDYsMCwxMS42OSwwLDExLjhzNDYuNzUtNC4xMiw0Ni44LTQuMDhBLjIxLjIxLDAsMCwwLDQ2Ljg4LDcuMzFaIi8+PHBhdGggY2xhc3M9ImNscy0xNyIgZD0iTTgzLjM5LDcuNjZDODMuMzEsNy42Nyw1NCwwLDU0LDBMMzIuMDUsMy4yYy0uMTEsMC0uMDguMTksMCwuMTdMNTQsLjU5Yy0uMzUsMCwyOS4zNiw3LjIzLDI5LjM1LDcuMjRhLjExLjExLDAsMCwwLC4wOC0uMDhBLjExLjExLDAsMCwwLDgzLjM5LDcuNjZaIi8+PHBhdGggY2xhc3M9ImNscy0xOCIgZD0iTTM2LjU3LDMzLjA2Yy4zNCwxMC44OS42NywyMS43OC41MSwzMi42N2gtLjJjLS4yNy01LjQ1LS4zOC0xMC44OS0uNDMtMTYuMzRzLS4xMS0xMC44OS0uMDktMTYuMzRaIi8+PHBhdGggY2xhc3M9ImNscy0xOSIgZD0iTTEuNzQsNDIuMzlDMSwzMi40My40MywyMS43OCwwLDExLjhILjEzYy41MSw3LjQ3LDEsMTUsMS4zNywyMi40My4xMywyLjQ5LjI1LDUsLjMyLDcuNDhsLS4wOC42OFoiLz48cGF0aCBjbGFzcz0iY2xzLTIwIiBkPSJNNjUuMTIsNTguMzljMC0xMC4xOC4zMy0yMC4zNi42OC0zMC41M0g2NmMwLDUuMDktLjE0LDEwLjE4LS4yMiwxNS4yN3MtLjIyLDEwLjE4LS40NiwxNS4yNloiLz48cGF0aCBjbGFzcz0iY2xzLTIxIiBkPSJNODEuMTcsMzAuNTZjLjIxLTMuNjguNjItOC4xOCwxLTExLjg0cy43LTcuMjYsMS4xNC0xMC45MWwuMTQtLjA2Yy0uMjQsMy42Ny0uNTQsNy4zNC0uODcsMTFzLS44LDguMTMtMS4yOCwxMS43OGwtLjEsMFoiLz48cGF0aCBjbGFzcz0iY2xzLTIyIiBkPSJNLjEzLDExLjhjLS4wOCwwLDM3LjIxLDIxLDM2LjM5LDIwLjczbDI5LjM0LTQuNzQsMCwuMTRMMzYuNDIsMzMuMzZDMzYuMzksMzMuMjEtLjIsMTIsLjEzLDExLjhaIi8+PHBvbHlnb24gY2xhc3M9ImNscy0yMyIgcG9pbnRzPSIwLjEzIDExLjggMC41NCAxMi4xMyAyLjI4IDQyLjA4IDEuODEgNDEuNzggMC4xMyAxMS44Ii8+PHBhdGggY2xhc3M9ImNscy0yNCIgZD0iTTgzLjI4LDcuODEsODIuMSwxOS4xNWwtLjg5LDEwLjYxLS4zLjA4LjgyLTEwLjYzTDgzLDcuODVBLjgzLjgzLDAsMCwxLDgzLjI4LDcuODFaIi8+PC9nPjwvZz48L2c+PC9zdmc+",
  };

  ZyreLibrary.Models.Template = Backbone.Model.extend({
    defaults: {
      template_id: 0,
      title: "",
      type: "",
      thumbnail: "",
      url: "",
      tags: [],
      isPro: false,
    },
  });

  ZyreLibrary.Collections.Template = Backbone.Collection.extend({
    model: ZyreLibrary.Models.Template,
  });

  ZyreLibrary.Behaviors.InsertTemplate = Marionette.Behavior.extend({
    ui: {
      insertButton: ".zyre-TemplateLibrary_insert-button",
    },
    events: {
      "click @ui.insertButton": "onInsertButtonClick",
    },
    onInsertButtonClick: function onInsertButtonClick() {
      zyre.library.insertTemplate({
        model: this.view.model,
      });
    },
  });

  ZyreLibrary.Views.EmptyTemplateCollection = Marionette.ItemView.extend({
    id: "elementor-template-library-templates-empty",
    template: "#tmpl-zyre-TemplateLibrary_empty",
    ui: {
      title: ".elementor-template-library-blank-title",
      message: ".elementor-template-library-blank-message",
    },
    modesStrings: {
      empty: {
        title: zyreGetTranslated("templatesEmptyTitle"),
        message: zyreGetTranslated("templatesEmptyMessage"),
      },
      noResults: {
        title: zyreGetTranslated("templatesNoResultsTitle"),
        message: zyreGetTranslated("templatesNoResultsMessage"),
      },
    },
    getCurrentMode: function getCurrentMode() {
      if (zyre.library.getFilter("text")) {
        return "noResults";
      }
      return "empty";
    },
    onRender: function onRender() {
      var modeStrings = this.modesStrings[this.getCurrentMode()];
      this.ui.title.html(modeStrings.title);
      this.ui.message.html(modeStrings.message);
    },
  });

  ZyreLibrary.Views.Loading = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_loading",
    id: "zyre-TemplateLibrary_loading",
  });

  ZyreLibrary.Views.Logo = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-logo",
    className: "zyre-TemplateLibrary_header-logo",
    templateHelpers: function templateHelpers() {
      return {
        title: this.getOption("title"),
      };
    },
  });

  ZyreLibrary.Views.BackButton = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-back",
    id: "elementor-template-library-header-preview-back",
    className: "zyre-TemplateLibrary_header-back",
    events: function events() {
      return {
        click: "onClick",
      };
    },
    onClick: function onClick() {
      zyre.library.showTemplatesView();
    },
  });

  ZyreLibrary.Views.Menu = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-menu",
    id: "elementor-template-library-header-menu",
    className: "zyre-TemplateLibrary_header-menu",
    templateHelpers: function templateHelpers() {
      return zyre.library.getTabs();
    },
    ui: {
      menuItem: ".elementor-template-library-menu-item",
    },
    events: {
      "click @ui.menuItem": "onMenuItemClick",
    },
    onMenuItemClick: function onMenuItemClick(event) {
      zyre.library.setFilter("tags", "");
      zyre.library.setFilter("text", "");
      zyre.library.setFilter("type", event.currentTarget.dataset.tab, true);
      zyre.library.showTemplatesView();
    },
  });

  ZyreLibrary.Views.ResponsiveMenu = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-menu-responsive",
    id: "elementor-template-library-header-menu-responsive",
    className: "zyre-TemplateLibrary_header-menu-responsive",
    ui: {
      items: "> .elementor-component-tab",
    },
    events: {
      "click @ui.items": "onTabItemClick",
    },
    onTabItemClick: function onTabItemClick(event) {
      var $target = $(event.currentTarget),
        device = $target.data("tab");
      zyre.library.channels.tabs.trigger("change:device", device, $target);
    },
  });

  ZyreLibrary.Views.Actions = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-actions",
    id: "elementor-template-library-header-actions",
    ui: {
      sync: "#zyre-TemplateLibrary_header-sync i",
    },
    events: {
      "click @ui.sync": "onSyncClick",
    },
    onSyncClick: function onSyncClick() {
      var self = this;
      self.ui.sync.addClass("eicon-animation-spin");
      zyre.library.requestLibraryData({
        onUpdate: function onUpdate() {
          self.ui.sync.removeClass("eicon-animation-spin");
          zyre.library.updateBlocksView();
        },
        forceUpdate: true,
        forceSync: true,
      });
    },
  });

  ZyreLibrary.Views.InsertWrapper = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_header-insert",
    id: "elementor-template-library-header-preview",
    behaviors: {
      insertTemplate: {
        behaviorClass: ZyreLibrary.Behaviors.InsertTemplate,
      },
    },
  });

  ZyreLibrary.Views.Preview = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_preview",
    className: "zyre-TemplateLibrary_preview",
    ui: function ui() {
      return {
        iframe: "> iframe",
      };
    },
    onRender: function onRender() {
      this.ui.iframe.attr("src", this.getOption("url")).hide();
      var self = this,
        loadingScreen = new ZyreLibrary.Views.Loading().render();

      this.$el.append(loadingScreen.el);
      this.ui.iframe.on("load", function () {
        self.$el.find("#zyre-TemplateLibrary_loading").remove();
        self.ui.iframe.show();
      });
    },
  });

  ZyreLibrary.Views.Notice = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_notice",
    className: "zyre-TemplateLibrary_notice-wrapper",
  });

  ZyreLibrary.Views.TemplateCollection = Marionette.CompositeView.extend({
    template: "#tmpl-zyre-TemplateLibrary_templates",
    id: "zyre-TemplateLibrary_templates",
    className: function className() {
      return (
        "zyre-TemplateLibrary_templates zyre-TemplateLibrary_templates--" +
        zyre.library.getFilter("type")
      );
    },
    childViewContainer: "#zyre-TemplateLibrary_templates-list",
    emptyView: function emptyView() {
      return new ZyreLibrary.Views.EmptyTemplateCollection();
    },
    ui: {
      templatesWindow: ".zyre-TemplateLibrary_templates-window",
      textFilter: "#zyre-TemplateLibrary_search",
      tagsFilter: "#zyre-TemplateLibrary_filter-tags",
      filterBar: "#zyre-TemplateLibrary_toolbar-filter",
      counter: "#zyre-TemplateLibrary_toolbar-counter",
    },
    events: {
      "input @ui.textFilter": "onTextFilterInput",
      "click @ui.tagsFilter li": "onTagsFilterClick",
    },
    getChildView: function getChildView(childModel) {
      return ZyreLibrary.Views.Template;
    },
    initialize: function initialize() {
      this.listenTo(
        zyre.library.channels.templates,
        "filter:change",
        this._renderChildren,
      );
    },
    filter: function filter(childModel) {
      var filterTerms = zyre.library.getFilterTerms(),
        passingFilter = true;
      _.each(filterTerms, function (filterTerm, filterTermName) {
        var filterValue = zyre.library.getFilter(filterTermName);
        if (!filterValue) {
          return;
        }
        if (filterTerm.callback) {
          var callbackResult = filterTerm.callback.call(
            childModel,
            filterValue,
          );
          if (!callbackResult) {
            passingFilter = false;
          }
          return callbackResult;
        }
      });
      return passingFilter;
    },
    setMasonrySkin: function setMasonrySkin() {
      if (zyre.library.getFilter("type") === "section") {
        var masonry = new elementorModules.utils.Masonry({
          container: this.$childViewContainer,
          items: this.$childViewContainer.children(),
        });
        this.$childViewContainer.imagesLoaded(masonry.run.bind(masonry));
      }
    },
    onRenderCollection: function onRenderCollection() {
      this.setMasonrySkin();
      this.updatePerfectScrollbar();
      this.setTemplatesFoundText();
    },
    setTemplatesFoundText: function setTemplatesFoundText() {
      var type = zyre.library.getFilter("type"),
        len = this.children.length,
        text = "<b>" + len + "</b>";
      text +=
        type === "section"
          ? " hero section"
          : type === "container"
            ? " block"
            : " " + type;
      if (len > 1) {
        text += "s";
      }
      text += " found";
      this.ui.counter.html(text);
    },
    onTextFilterInput: function onTextFilterInput() {
      var self = this;
      _.defer(function () {
        zyre.library.setFilter("text", self.ui.textFilter.val());
      });
    },
    onTagsFilterClick: function onTagsFilterClick(event) {
      var $select = $(event.currentTarget),
        tag = $select.data("tag");
      zyre.library.setFilter("tags", tag);
      $select.addClass("active").siblings().removeClass("active");
      if (!tag) {
        tag = "Filter";
      } else {
        tag = zyre.library.getTags()[tag];
      }
      this.ui.filterBar
        .find(".zyre-TemplateLibrary_filter-btn")
        .html(tag + ' <i class="eicon-caret-down"></i>');
    },
    updatePerfectScrollbar: function updatePerfectScrollbar() {
      if (!this.perfectScrollbar) {
        this.perfectScrollbar = new PerfectScrollbar(
          this.ui.templatesWindow[0],
          {
            suppressScrollX: true,
          },
        ); // The RTL is buggy, so always keep it LTR.
      }
      this.perfectScrollbar.isRtl = false;
      this.perfectScrollbar.update();
    },
    setTagsFilterHover: function setTagsFilterHover() {
      var self = this;
      self.ui.filterBar.hoverIntent(
        function () {
          self.ui.tagsFilter.css("display", "block");
          self.ui.filterBar
            .find(".zyre-TemplateLibrary_filter-btn i")
            .addClass("eicon-caret-down")
            .removeClass("eicon-caret-right");
        },
        function () {
          self.ui.tagsFilter.css("display", "none");
          self.ui.filterBar
            .find(".zyre-TemplateLibrary_filter-btn i")
            .addClass("eicon-caret-right")
            .removeClass("eicon-caret-down");
        },
        {
          sensitivity: 50,
          interval: 150,
          timeout: 100,
        },
      );
    },
    onRender: function onRender() {
      // Render notice before list
      var noticeView = new ZyreLibrary.Views.Notice();
      this.$el.prepend(noticeView.render().el);

      this.setTagsFilterHover();
      this.updatePerfectScrollbar();
    },
  });

  ZyreLibrary.Views.Template = Marionette.ItemView.extend({
    template: "#tmpl-zyre-TemplateLibrary_template",
    className: "zyre-TemplateLibrary_template",
    ui: {
      previewButton:
        ".zyre-TemplateLibrary_preview-button, .zyre-TemplateLibrary_template-preview",
    },
    events: {
      "click @ui.previewButton": "onPreviewButtonClick",
    },
    behaviors: {
      insertTemplate: {
        behaviorClass: ZyreLibrary.Behaviors.InsertTemplate,
      },
    },
    onPreviewButtonClick: function onPreviewButtonClick() {
      zyre.library.showPreviewView(this.model);
    },
  });

  ZyreLibrary.Modal = elementorModules.common.views.modal.Layout.extend({
    getModalOptions: function getModalOptions() {
      return {
        id: "zyre-TemplateLibrary_modal",
        hide: {
          onOutsideClick: false,
          onEscKeyPress: true,
          onBackgroundClick: false,
        },
      };
    },
    getTemplateActionButton: function getTemplateActionButton(templateData) {
      var templateName =
          templateData.isPro && !ZyreAddonsEditor.hasPro
            ? "pro-button"
            : "insert-button",
        viewId = "#tmpl-zyre-TemplateLibrary_" + templateName,
        template = Marionette.TemplateCache.get(viewId);
      return Marionette.Renderer.render(template);
    },
    showLogo: function showLogo(args) {
      this.getHeaderView().logoArea.show(new ZyreLibrary.Views.Logo(args));
    },
    showDefaultHeader: function showDefaultHeader() {
      this.showLogo({
        title: "TEMPLATES",
      });
      var headerView = this.getHeaderView();

      headerView.tools.show(new ZyreLibrary.Views.Actions());
      headerView.menuArea.show(new ZyreLibrary.Views.Menu());
      // headerView.menuArea.reset();
    },
    showPreviewView: function showPreviewView(templateModel) {
      var headerView = this.getHeaderView();

      headerView.menuArea.show(new ZyreLibrary.Views.ResponsiveMenu());
      headerView.logoArea.show(new ZyreLibrary.Views.BackButton());
      headerView.tools.show(
        new ZyreLibrary.Views.InsertWrapper({
          model: templateModel,
        }),
      );
      this.modalContent.show(
        new ZyreLibrary.Views.Preview({
          url: templateModel.get("url"),
        }),
      );
    },
    showTemplatesView: function showTemplatesView(templatesCollection) {
      this.showDefaultHeader();
      this.modalContent.show(
        new ZyreLibrary.Views.TemplateCollection({
          collection: templatesCollection,
        }),
      );
    },
  });

  ZyreLibrary.Manager = function () {
    var modal,
      tags,
      typeTags,
      self = this,
      templatesCollection,
      errorDialog,
      FIND_SELECTOR =
        ".elementor-add-new-section .elementor-add-section-drag-title",
      $openLibraryButton = `<div class="elementor-add-section-area-button elementor-add-zyre-button"><img src="${ZyreLibrary.Icon3d}" width="40"></div>`,
      devicesResponsiveMap = {
        desktop: "100%",
        tab: "768px",
        mobile: "360px",
      };
    this.atIndex = -1;
    this.channels = {
      tabs: Backbone.Radio.channel("tabs"),
      templates: Backbone.Radio.channel("templates"),
    };
    function addZyreTemplatesOpenButton(e, a) {
      var $elementorAddSection = $(e.target)
        .parents(a)
        .prev(".elementor-add-section");
      if (!$elementorAddSection.find(".elementor-add-zyre-button").length) {
        $elementorAddSection.find(FIND_SELECTOR).before($openLibraryButton);
      }
    }
    function addLibraryModalOpenButton($previewContents) {
      var $addNewSection = $previewContents.find(FIND_SELECTOR);
      if (
        $addNewSection.length &&
        !$previewContents.find(".elementor-add-zyre-button").length
      ) {
        $addNewSection.before($openLibraryButton);
      }
      $previewContents.on(
        "click.onZyreTemplatesOpenButton",
        ".elementor-editor-section-settings .elementor-editor-element-add",
        function (e) {
          addZyreTemplatesOpenButton(e, ".elementor-top-section");
        },
      );
      $previewContents.on(
        "click.onZyreTemplatesOpenButton",
        ".elementor-editor-container-settings .elementor-editor-element-add",
        function (e) {
          addZyreTemplatesOpenButton(e, ".e-parent");
        },
      );
    }
    function onDeviceChange(device, $target) {
      $target
        .addClass("elementor-active")
        .siblings()
        .removeClass("elementor-active");
      var width =
        devicesResponsiveMap[device] || devicesResponsiveMap["desktop"];
      $(".zyre-TemplateLibrary_preview").css("width", width);
    }
    function onPreviewLoaded() {
      var $previewContents = window.elementor.$previewContents,
        time = setInterval(function () {
          addLibraryModalOpenButton($previewContents);
          $previewContents.find(".elementor-add-new-section").length > 0 &&
            clearInterval(time);
        }, 100);
      $previewContents.on(
        "click.onZyreAddTemplateButton",
        ".elementor-add-zyre-button",
        self.showModal.bind(self),
      );
      this.channels.tabs.on("change:device", onDeviceChange);
    }
    this.updateBlocksView = function () {
      self.setFilter("tags", "", true);
      self.setFilter("text", "", true);
      self.getModal().showTemplatesView(templatesCollection);
    };
    this.setFilter = function (name, value, silent) {
      self.channels.templates.reply("filter:" + name, value);
      if (!silent) {
        self.channels.templates.trigger("filter:change");
      }
    };
    this.getFilter = function (name) {
      return self.channels.templates.request("filter:" + name);
    };
    this.getFilterTerms = function () {
      return {
        tags: {
          callback: function callback(value) {
            return _.any(this.get("tags"), function (tag) {
              return tag.indexOf(value) >= 0;
            });
          },
        },
        text: {
          callback: function callback(value) {
            value = value.toLowerCase();
            if (this.get("title").toLowerCase().indexOf(value) >= 0) {
              return true;
            }
            return _.any(this.get("tags"), function (tag) {
              return tag.indexOf(value) >= 0;
            });
          },
        },
        type: {
          callback: function callback(value) {
            return this.get("type") === value;
          },
        },
      };
    };
    this.showModal = function () {
      self.getModal().showModal();
      self.showTemplatesView();
    };
    this.closeModal = function () {
      this.getModal().hideModal();
    };
    this.getModal = function () {
      if (!modal) {
        modal = new ZyreLibrary.Modal();
      }
      return modal;
    };
    this.init = function () {
      self.setFilter("type", "section", true);
      elementor.on("preview:loaded", onPreviewLoaded.bind(this));
    };
    this.getTabs = function () {
      var type = this.getFilter("type"),
        tabs = {
          section: {
            title: "Hero Sections",
          },
          container: {
            title: "Blocks",
          },
          page: {
            title: "Pages",
          },
        };
      _.each(tabs, function (obj, key) {
        if (type === key) {
          tabs[type].active = true;
        }
      });
      return {
        tabs: tabs,
      };
    };
    this.getTags = function () {
      return tags;
    };
    this.getTypeTags = function () {
      var type = self.getFilter("type");
      return typeTags[type];
    };
    this.showTemplatesView = function () {
      self.setFilter("tags", "", true);
      self.setFilter("text", "", true);
      if (!templatesCollection) {
        self.loadTemplates(function () {
          self.getModal().showTemplatesView(templatesCollection);
        });
      } else {
        self.getModal().showTemplatesView(templatesCollection);
      }
    };
    this.showPreviewView = function (templateModel) {
      self.getModal().showPreviewView(templateModel);
    };
    this.loadTemplates = function (_onUpdate) {
      self.requestLibraryData({
        onBeforeUpdate: self.getModal().showLoadingView.bind(self.getModal()),
        onUpdate: function onUpdate() {
          self.getModal().hideLoadingView();
          if (_onUpdate) {
            _onUpdate();
          }
        },
      });
    };
    this.requestLibraryData = function (options) {
      if (templatesCollection && !options.forceUpdate) {
        if (options.onUpdate) {
          options.onUpdate();
        }
        return;
      }
      if (options.onBeforeUpdate) {
        options.onBeforeUpdate();
      }
      var ajaxOptions = {
        data: {},
        success: function success(data) {
          templatesCollection = new ZyreLibrary.Collections.Template(
            data.templates,
          );
          if (data.tags) {
            tags = data.tags;
          }
          if (data.type_tags) {
            typeTags = data.type_tags;
          }
          if (options.onUpdate) {
            options.onUpdate();
          }
        },
      };

      if (options.forceSync) {
        ajaxOptions.data.sync = true;
      }
      elementorCommon.ajax.addRequest("get_zyre_library_data", ajaxOptions);
    };
    this.requestTemplateData = function (template_id, ajaxOptions) {
      var options = {
        unique_id: template_id,
        data: {
          edit_mode: true,
          display: true,
          template_id: template_id,
        },
      };
      if (ajaxOptions) {
        jQuery.extend(true, options, ajaxOptions);
      }
      elementorCommon.ajax.addRequest("get_zyre_template_data", options);
    };
    this.insertTemplate = function (args) {
      var model = args.model,
        self = this;
      self.getModal().showLoadingView();
      self.requestTemplateData(model.get("template_id"), {
        success: function success(data) {
          self.getModal().hideLoadingView();
          self.getModal().hideModal();
          var options = {};
          if (self.atIndex !== -1) {
            options.at = self.atIndex;
          }
          $e.run("document/elements/import", {
            model: model,
            data: data,
            options: options,
          });
          self.atIndex = -1;
        },
        error: function error(data) {
          self.showErrorDialog(data);
        },
        complete: function complete(data) {
          self.getModal().hideLoadingView();
          window.elementor.$previewContents
            .find(".elementor-add-section .elementor-add-section-close")
            .click();
        },
      });
    };
    this.showErrorDialog = function (errorMessage) {
      if ("object" === _typeof(errorMessage)) {
        var message = "";
        _.each(errorMessage, function (error) {
          message += "<div>" + error.message + ".</div>";
        });
        errorMessage = message;
      } else if (errorMessage) {
        errorMessage += ".";
      } else {
        errorMessage = "<i>&#60;The error message is empty&#62;</i>";
      }
      self
        .getErrorDialog()
        .setMessage(
          "The following error(s) occurred while processing the request:" +
            '<div id="elementor-template-library-error-info">' +
            errorMessage +
            "</div>",
        )
        .show();
    };
    this.getErrorDialog = function () {
      if (!errorDialog) {
        errorDialog = elementorCommon.dialogsManager.createWidget("alert", {
          id: "elementor-template-library-error-dialog",
          headerMessage: "An error occurred",
        });
      }
      return errorDialog;
    };
  };

  zyre.library = new ZyreLibrary.Manager();
  zyre.library.init();
  window.zyre = zyre;
})(jQuery, window.elementor, window.zyre || {});
