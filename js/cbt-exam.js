
    function loginTrigger() {
        const getJambReg = document.getElementById("jamb-reg");
        const getJambPass = document.getElementById("jamb-pass");
        const getJambMsg = document.getElementById("jamb-msg");

        if(getJambReg.value.trim().length > 0){
            getJambMsg.innerHTML = "";
            if(getJambPass.value.trim().length > 0){
                getJambMsg.innerHTML = "";
                if(getJambReg.value == "zainab2024"){
                    getJambMsg.innerHTML = "";
                    if(getJambPass.value == "1234567890"){
                        getJambMsg.innerHTML = "Success, You will Be Redirected Shortly";
                        setTimeout(() => {
                            window.location.href = "quiz.html";
                        }, 3000);
                    }else{
                        getJambMsg.innerHTML = "Invalid Password";
                    }
                }else{
                    getJambMsg.innerHTML = "Invalid Jamb Registration Number";
                }
            }else{
                getJambMsg.innerHTML = "Password Field Is Empty";
            }
        }else{
            getJambMsg.innerHTML = "Registration Number Field Is Empty";
        }
    }
	
	function timeFormater(timeSecs) {
		if(Number(timeSecs) > 0){
			const HrsTimeFormat = Math.floor(((timeSecs / 60) / 60));
			const MinsTimeFormat = Math.floor((timeSecs - (HrsTimeFormat * 60 * 60)) / 60);
			const SecsTimeFormat = Math.floor((timeSecs - (HrsTimeFormat * 60 * 60) - (MinsTimeFormat * 60)));
			
			return String(HrsTimeFormat).padStart(2, 0) + ":" + String(MinsTimeFormat).padStart(2, 0) + ":" + String(SecsTimeFormat).padStart(2, 0);
		}else{
			return "00:00:00";
		}
	}
		
    //Selected Answer
    const selectedAnswerArr = {};
    
    //Select Answer Function
    function selectAnswer() {
        const jambQuest = document.getElementById("jamb-quest");
        const selectedAnswer = document.getElementsByName("radioAns");
        for(let x = 0; x < selectedAnswer.length; x++){
            if(selectedAnswer[x].checked == true){
                const getJambQuestNumber = jambQuest.getAttribute("quest-numbering");
                selectedAnswerArr[getJambQuestNumber] = selectedAnswer[x].value;
                console.log(selectedAnswerArr);
            }
        }
    }

    //Questions
    const retainQuestions = [];
    const retainAnswers = [];
    const allQuestionsObjArrDetails = getAllQuestionsObjArrDetails;
	
	let examNumberAttemptable = allQuestionsObjArrDetails["examAttempts"];
	examNumberAttemptable = examNumberAttemptable || "all";
	if((Number(examNumberAttemptable) > 0)){
		if(Number(examNumberAttemptable) <= allQuestionsObjArrDetails["quiz"].length){
			examNumberAttemptable = parseInt(examNumberAttemptable);
		}else{
			examNumberAttemptable = allQuestionsObjArrDetails["quiz"].length;
		}
	}else{
		if(examNumberAttemptable == "all"){
			examNumberAttemptable = allQuestionsObjArrDetails["quiz"].length;
		}else{
			if(examNumberAttemptable == "" || "0"){
				examNumberAttemptable = allQuestionsObjArrDetails["quiz"].length;
			}
		}
	}
	
	const questionObjArr = 
	{
		exams: allQuestionsObjArrDetails["exams"],
		time: allQuestionsObjArrDetails["time"],
		examAttempts: examNumberAttemptable,
	    quiz:[ ...allQuestionsObjArrDetails["quiz"].sort(() => Math.random() - 0.5) .slice(0, examNumberAttemptable) ]
	};
	
	//Set Exam Name
	if(questionObjArr["exams"]){
		const examName = document.getElementById("jamb-exam");
		examName.innerHTML = "<strong>Exam:</strong> " + questionObjArr["exams"].join(", ");
	}
	
	//Set Question Array
    for(let x = 0; x < questionObjArr["quiz"].length; x++){
        const questionNo = x + 1;
        retainQuestions.push([questionObjArr["quiz"][x]["question"],[questionObjArr["quiz"][x]["answers"]["correct"], ...questionObjArr["quiz"][x]["answers"]["wrong"]].slice().sort(() => Math.random() - 0.5),[questionObjArr["quiz"][x]["answers"]["correct"]]]);
    	retainAnswers.push(questionObjArr["quiz"][x]["answers"]["correct"]);
    	selectedAnswerArr[questionNo] = "";
    }

    //alert(retainQuestions);
    // for(let x in questionObjArr){
    //     retainAnswers.push([x, questionObjArr[x]]);
    // }
    // alert(Object.keys(questionObjArr["quiz"][0]["answers"]));

    //Set Questions
    function setQuestions(questionNo) {
        const questionNumber = Number(questionNo);
        if((retainQuestions.length > 0) && (questionNumber > 0) && (questionNumber <= retainQuestions.length)){
            const setFirstQuestion = retainQuestions[questionNumber - 1];
            const jambQuestContainer = document.getElementById("question-container");
            jambQuestContainer.innerHTML = "";
            const questAnswersArr = [... new Set(setFirstQuestion[1])];
            for(let i = 0; i < questAnswersArr.length; i++){
                const createQuestionCounterDiv = document.createElement("div");
                createQuestionCounterDiv.id = "question-counter";
                createQuestionCounterDiv.className = "m-block-dp m-font-size-20 s-font-size-22";
                createQuestionCounterDiv.style = "color: black; margin: auto auto 2% auto;";
                
                const createDiv = document.createElement("div");
                createDiv.id = "jamb-quest";
                createDiv.className = "m-block-dp m-font-size-18 s-font-size-20";
                createDiv.style = "color: black; margin: auto auto 2% auto;";
                createDiv.setAttribute("quest-numbering",questionNumber);

                const createAnswerDiv = document.createElement("div");
                createAnswerDiv.className = "m-width-80 m-height-auto m-block-dp";
                createAnswerDiv.style = "text-align: left; margin: auto;";
                
                const createInput = document.createElement("input");
                createInput.type = "radio";
                createInput.name = "radioAns";
                createInput.value = questAnswersArr[i];
                createInput.onclick = selectAnswer;
                createInput.id = "selectedAnswer_" + questionNumber + "_" + i;
                createInput.className = "a-cursor m-width-auto s-width-auto m-height-auto m-inline-dp outline-none br-radius-5px m-margin-lt-0 m-margin-bm-2";
                createInput.style = "text-align: center; accent-color: olivedrab; padding: 1% 2%; border: 2px solid olivedrab;";
                if(selectedAnswerArr[questionNumber]){
                    if(selectedAnswerArr[questionNumber] == questAnswersArr[i]){
                        createInput.checked = true;
                    }
                }

                const createLabel = document.createElement("label");
                createLabel.id = "jamb-answer";
                createLabel.className = "m-inline-dp m-font-size-16 s-font-size-18";
                createLabel.style = "color: black; word-break: break-word;";
                createLabel.innerHTML = decodeURIComponent(escape(atob(questAnswersArr[i])));
                createLabel.setAttribute("for", "selectedAnswer_" + questionNumber + "_" + i);
				
                createAnswerDiv.appendChild(createInput);
                createAnswerDiv.appendChild(createLabel);
                jambQuestContainer.appendChild(createQuestionCounterDiv);
                jambQuestContainer.appendChild(createDiv);
                jambQuestContainer.appendChild(createAnswerDiv);
            }
            const examCounter = document.getElementById("exam-counter");
            examCounter.innerHTML = "<strong>Questions:</strong> " + questionObjArr["quiz"].length;
            
            
            const questionNumberSpan = document.getElementById("question-counter");
            questionNumberSpan.innerHTML = "<strong>Questions:</strong> " + questionNumber;
        	
        	const jambQuest = document.getElementById("jamb-quest");
        	jambQuest.innerHTML = decodeURIComponent(escape(atob(setFirstQuestion[0]))).replaceAll("\n", "<br>");
        }
    }
    
    let examStartTime = "0";
    function examStartTimeFunc(examTimeRange) {
    	const getJambTimer = document.getElementById("exam-time");
    	if(examTimeRange.length > 0){
		    const [examHrs = "0", examMins = "0", examSecs = "0"] = examTimeRange.trim().split(":");
    
    		if((Number(examHrs) >= 0) && (Number(examHrs) <= 59) && (Number(examMins) >= 0) && (Number(examMins) <= 59) && (Number(examSecs) >= 0) && (Number(examSecs) <= 59)){
		    	const hrsToSecs = (examHrs * 60 * 60);
    			const minsToSecs = (examMins * 60);
    			const secsToSecs = (examSecs * 1);
    			const allExamSecs = (hrsToSecs + minsToSecs + secsToSecs);
    			examStartTime = allExamSecs;
    			if(examStartTime > 0){
		    		//Set First Question On Load
    				setQuestions(1);
    			}
    			getJambTimer.innerHTML = "<strong>Time Remaining:</strong> " + timeFormater(examStartTime);
    			setInterval(() => {
    				if(examStartTime > 0){
    					getJambTimer.innerHTML = "<strong>Time Remaining:</strong> " + timeFormater((examStartTime - 1));
    					examStartTime = (examStartTime - 1);
    					if(examStartTime == 0){
    						submitExam("submit");
    					}
    				}
    			}, 1000);
    		}else{
    
    		}
    	}
    }
    
    //Set Exam Time
    examStartTimeFunc(questionObjArr["time"]);
    
    //Set First Question On Load
    //setQuestions(1);
	
	//Submit Exam
	function submitExam(exception) {
		const allAnswersCorrectionArr = [];
		const allCorrectAnswers = [];
	
		const getSelectedAnswers = selectedAnswerArr;
		const getSelectedAnswersKey = Object.keys(getSelectedAnswers);
		const getSelectedAnswersValue = Object.values(getSelectedAnswers);
		allAnswersCorrectionArr.length = 0;
		allCorrectAnswers.length = 0;
		if((exception == "submit") || (confirm("Are you sure you want to submit exam?"))){
			if(getSelectedAnswersKey.length > 0){
				examStartTime = 0;
				for(let x = 0; x < getSelectedAnswersValue.length; x++){
					if(getSelectedAnswersValue[x] == retainAnswers[x]){
						allCorrectAnswers.push(getSelectedAnswersKey[x]);
						allAnswersCorrectionArr.push("<b>Correct Answer</b>: " + getSelectedAnswersValue[x]);
					}else{
						allAnswersCorrectionArr.push("<b>Incorrect Answer</b>: " + getSelectedAnswersValue[x] + "\n" + "<b>Correct Answer</b>: " + retainAnswers[x]);
					}
				}
			}else{
				alert("No Question Has Been Attempted");
			}
		// const ExamContainer = document.getElementById("exam-container");
		// //CorrectionsDiv
		// const createDiv = document.createElement("div");
		// createDiv.className = "m-width-90 s-width-70 m-height-auto m-block-dp";
		// createDiv.style = "text-align: center; margin: auto auto 5% auto;";
		
		// //Score Span
		// const createCorrectionSpan = document.createElement("span");
		// createCorrectionSpan.className = "m-width-40 m-height-auto m-inline-block-dp m-font-size-20 s-font-size-25 m-margin-tp-5 m-margin-bm-auto br-radius-50";
		// createCorrectionSpan.style = "text-align: center; padding: 5% 2%; background-color: olivedrab; color: antiquewhite; word-break: break-word;";
		// createCorrectionSpan.innerHTML = "Score: " + ((allCorrectAnswers.length / allAnswersCorrectionArr.length) * 100) + "%";
		// createDiv.appendChild(createCorrectionSpan);
		
		// //Correction H2
		// const createH2 = document.createElement("h2");
		// createH2.style = "color: olivedrab;";
		// createH2.innerHTML = "CORRECTIONS";
		
		// createDiv.appendChild(createH2);
		// for(let x = 0; x < retainQuestions.length; x++){
		// 	const questNo = x + 1;
		// 	//Questions Tag
		// 	const createSpan = document.createElement("span");
		// 	createSpan.className = "m-block-dp m-font-size-16 s-font-size-18 m-margin-bm-2";
		// 	createSpan.style = "text-align: left; color: black; word-break: break-word;";
		// 	createSpan.innerHTML = questNo + ". " + retainQuestions[x][0];
			
		// 	//Correction Tag
		// 	const createSpan_2 = document.createElement("span");
		// 	createSpan_2.className = "m-block-dp m-font-size-16 s-font-size-18 m-margin-lt-10 m-margin-bm-2";
		// 	createSpan_2.style = "text-align: left; color: black; word-break: break-word;";
		// 	createSpan_2.innerHTML = allAnswersCorrectionArr[x].replaceAll("\n", "<br>");
			
		// 	createDiv.appendChild(createSpan);
		// 	createDiv.appendChild(createSpan_2);
		// }
		
		// ExamContainer.appendChild(createDiv);

		//alert("Your Score is: "+allCorrectAnswers.length + " CBT ID: " + cbtExamIdentifier);
		
		const fetchXMLRequest = new XMLHttpRequest();
		fetchXMLRequest.open("POST", "cbt-remark.php");
		fetchXMLRequest.setRequestHeader("Content-Type", "aplication/json");
		fetchXMLRequestStr = JSON.stringify({"id": cbtExamIdentifier, "score": allCorrectAnswers.length});
		fetchXMLRequest.onload = function () {
			if((fetchXMLRequest.readyState === 4) && (fetchXMLRequest.status === 200)) {
				const responseJSON = JSON.parse(fetchXMLRequest.responseText);
				const popUpDivArr = document.getElementsByClassName("cbt-test-popup-div");
				popUpDivArr[0].innerHTML = "";
				createExamHeader = document.createElement("span");
				createExamHeader.className = "mobile-font-size-20 system-font-size-25";
				createExamHeader.style = "color: olivedrab; display: block;";
				
				if(responseJSON.response == 1){
					createExamHeader.innerHTML = "EXAM SUBMITTED SUCCESSFULLY.<br/>";
					createExamHeader.innerHTML += "You can now leave the hall, This page will be reloaded in 5seconds!";
				}else{
					if(responseJSON.response == 2){
						createExamHeader.innerHTML = "ERROR: SUBMISSION UNSUCCESSFUL.<br/>";
						createExamHeader.innerHTML += "An Error was encountered, This page will be reloaded in 5seconds!";
					}else{
						createExamHeader.innerHTML = "ERROR: COULD NOT CONNECT.<br/>";
						createExamHeader.innerHTML += "An Error was encountered, This page will be reloaded in 5seconds!";
					}
				}
				popUpDivArr[0].appendChild(createExamHeader);
			}
		}
		fetchXMLRequest.send(fetchXMLRequestStr);

		const examSubmitBtn = document.getElementById("submit-btn");
		examSubmitBtn.disabled = true;
		if(exception == "submit"){
			examSubmitBtn.innerHTML = "Timeout";
		}else{
			examSubmitBtn.innerHTML = "Submitted";
		}
		closeAfterSubmissionExamPopUpDiv();
		}
	}
	
    function prevButton(){
        const jambQuest = document.getElementById("jamb-quest");
        if(Number(jambQuest.getAttribute("quest-numbering")) > 1){
            setQuestions(Number(jambQuest.getAttribute("quest-numbering")) - 1);
        }
    }

    function nextButton(){
        const jambQuest = document.getElementById("jamb-quest");
        if(Number(jambQuest.getAttribute("quest-numbering")) < retainQuestions.length){
            setQuestions(Number(jambQuest.getAttribute("quest-numbering")) + 1);
        }
    }

    