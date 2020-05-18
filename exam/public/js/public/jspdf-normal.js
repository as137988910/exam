(function (jsPDFAPI) {
var font = 'undefined';
var callAddFont = function () {
this.addFileToVFS('哈哈哈与我粤-normal.ttf', font);
this.addFont('哈哈哈与我粤-normal.ttf', '哈哈哈与我粤', 'normal');
};
jsPDFAPI.events.push(['addFonts', callAddFont])
 })(jsPDF.API);