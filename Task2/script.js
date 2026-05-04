function analyzeEmail() {
    let text = document.getElementById("emailText").value.toLowerCase();
    let result = document.getElementById("result");
    let details = document.getElementById("details");

    let score = 0;
    let reasons = [];

    // Rule 1: Suspicious keywords
    let keywords = ["urgent", "click here", "verify account", "password reset", "bank", "limited time"];
    keywords.forEach(word => {
        if (text.includes(word)) {
            score++;
            reasons.push("Contains suspicious keyword: " + word);
        }
    });

    // Rule 2: Fake links (http)
    if (text.includes("http://")) {
        score++;
        reasons.push("Contains insecure link (http)");
    }

    // Rule 3: Suspicious domains
    if (text.includes("amaz0n") || text.includes("paypa1")) {
        score++;
        reasons.push("Possible spoofed domain detected");
    }

    // Rule 4: Attachments warning
    if (text.includes(".exe") || text.includes(".zip")) {
        score++;
        reasons.push("Suspicious attachment detected");
    }

    // Result classification
    if (score === 0) {
        result.innerHTML = "✅ Safe Email";
        result.className = "safe";
    } 
    else if (score <= 2) {
        result.innerHTML = "⚠ Suspicious Email";
        result.className = "suspicious";
    } 
    else {
        result.innerHTML = "❌ Phishing Email";
        result.className = "phishing";
    }

    // Show reasons
    details.innerHTML = "<b>Analysis:</b><br>" + reasons.join("<br>");
}
