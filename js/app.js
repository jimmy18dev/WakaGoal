$(document).ready(function(){
    // Create Class
    var bpm = new BPM();

    bpm.deathRate('deathRate')
    bpm.cmi('cmi')
    bpm.topDiag('TopDiagOPD','opd')
    bpm.topDiag('TopDiagIPD','ipd')
    bpm.admitIPD('AdmitIPD')

    bpm.visitCounter('visitYear','year')
    bpm.visitCounter('visitMonth','month')
    bpm.visitCounter('visitDay','day')
});