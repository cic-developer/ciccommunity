const caver = require('./caver');

const token_abi = [{
        constant: true,
        inputs: [],
        name: "name",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "approve",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "totalSupply",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transferFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "decimals",
        outputs: [{ name: "", type: "uint8" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "_value", type: "uint256" }],
        name: "burn",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "balanceOf",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_from", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "burnFrom",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [],
        name: "release",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "owner",
        outputs: [{ name: "", type: "address" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "symbol",
        outputs: [{ name: "", type: "string" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: true,
        inputs: [],
        name: "released",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_to", type: "address" },
            { name: "_value", type: "uint256" },
        ],
        name: "transfer",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [{ name: "", type: "address" }],
        name: "frozenAccount",
        outputs: [{ name: "", type: "bool" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "_spender", type: "address" },
            { name: "_value", type: "uint256" },
            { name: "_extraData", type: "bytes" },
        ],
        name: "approveAndCall",
        outputs: [{ name: "success", type: "bool" }],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: true,
        inputs: [
            { name: "", type: "address" },
            { name: "", type: "address" },
        ],
        name: "allowance",
        outputs: [{ name: "", type: "uint256" }],
        payable: false,
        stateMutability: "view",
        type: "function",
    },
    {
        constant: false,
        inputs: [
            { name: "target", type: "address" },
            { name: "freeze", type: "bool" },
        ],
        name: "freezeAccount",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        constant: false,
        inputs: [{ name: "newOwner", type: "address" }],
        name: "transferOwnership",
        outputs: [],
        payable: false,
        stateMutability: "nonpayable",
        type: "function",
    },
    {
        inputs: [
            { name: "initialSupply", type: "uint256" },
            { name: "tokenName", type: "string" },
            { name: "tokenSymbol", type: "string" },
        ],
        payable: false,
        stateMutability: "nonpayable",
        type: "constructor",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: false, name: "target", type: "address" },
            { indexed: false, name: "frozen", type: "bool" },
        ],
        name: "FrozenFunds",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: true, name: "to", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Transfer",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "_owner", type: "address" },
            { indexed: true, name: "_spender", type: "address" },
            { indexed: false, name: "_value", type: "uint256" },
        ],
        name: "Approval",
        type: "event",
    },
    {
        anonymous: false,
        inputs: [
            { indexed: true, name: "from", type: "address" },
            { indexed: false, name: "value", type: "uint256" },
        ],
        name: "Burn",
        type: "event",
    },
];
const token_address = "0x7eee60a000986e9efe7f5c90340738558c24317b";
const PER = new caver.klay.Contract(token_abi, token_address);

const getNetworkResults = document.getElementById("connectNetwork");
const getAccountAddress = document.getElementById("getAccountAddress");
const getAccountsResults = document.getElementById("getAccountsResult");

// transfer
const RunTransfer = document.getElementById("RunTransfer");
const ToAddress = document.getElementById("ToAddress");
const ToValue = document.getElementById("ToValue");
const txhash = document.getElementById("txhash");
const reciept = document.getElementById("reciept");
const success_fromAddress = document.getElementById("success_fromAddress");
const success_toAddress = document.getElementById("success_toAddress");
const success_value = document.getElementById("success_value");

// kai-kas 연결 함수
connectAccountInfo = async() => {
    const { klaytn } = window;
    if (klaytn) {
        try {
            // 연결되면
            await klaytn.enable();
            // setAccountInfo() 로 카이카스 정보 불러오기
            this.setAccountInfo(klaytn);
            console.log("kai-kas 연결 성공");
        } catch (error) {
            // 연결실패
            console.log("kai-kas 연결 실패");
        }
    } else {
        // 카이카스가 설치되어있지 않음
        console.log("kai-kas가 설치되어 있지 않은 브라우져 입니다.");
    }
};

setAccountInfo = async() => {
    const { klaytn } = window;
    if (klaytn === undefined) return;

    // 클레이튼에 접속되어있는 월렛주소
    const account = klaytn.selectedAddress;

    //
    const balance = await caver.klay.getBalance(account);
    const token_balance = await PER.methods.balanceOf(account).call();

    // 8217 = 메인넷 , 1001 = 테스트넷
    getNetworkResults.innerHTML =
        klaytn.networkVersion == 8217 ? "메인넷" : "테스트넷";

    getAccountAddress.innerHTML = account;

    getAccountsResults.innerHTML = token_balance / 1000000000000000000 + " PER";
};

RunTransfer.onclick = async() => {
    const { klaytn } = window;
    if (klaytn === undefined) return;
    const account = klaytn.selectedAddress;

    const data = caver.klay.abi.encodeFunctionCall({
        name: "transfer",
        type: "function",
        inputs: [{
                type: "address",
                name: "_to",
            },
            {
                type: "uint256",
                name: "_value",
            },
        ],
    }, [
        ToAddress.value,
        caver.utils
        .toBN(ToValue.value)
        .mul(caver.utils.toBN(Number(`1e${18}`)))
        .toString(),
    ]);

    caver.klay
        .sendTransaction({
            type: "SMART_CONTRACT_EXECUTION",
            account,
            to: token_address,
            data,
            gas: 3000000,
        })
        .on("transactionHash", (transactionHash) => {
            console.log("txHash", transactionHash);
            txhash.innerHTML = `https://scope.klaytn.com/tx/${transactionHash}?tabId=internalTx`;
        })
        .on("receipt", (receipt) => {
            console.log("receipt", receipt);
            reciept.innerHTML = JSON.stringify(receipt);
            success_fromAddress.innerHTML = receipt.from;
            success_toAddress.innerHTML = receipt.logs[0].topics[2];
            success_value.innerHTML =
                caver.utils.hexToNumberString(receipt.logs[0].data) /
                1000000000000000000;
        })
        .on("error", (error) => {
            console.log("error", error);
        });
};